<?php

namespace Xoco70\LaravelTournaments\TreeGen;

use Illuminate\Support\Collection;
use Xoco70\LaravelTournaments\Exceptions\TreeGenerationException;
use Xoco70\LaravelTournaments\Models\ChampionshipSettings;
use Xoco70\LaravelTournaments\Models\PreliminaryFight;
use Xoco70\LaravelTournaments\Models\SingleEliminationFight;

abstract class SingleEliminationTreeGen extends TreeGen
{
    /**
     * Calculate the Byes needed to fill the Championship Tree.
     *
     * @param $fighters
     *
     * @return Collection
     */
    protected function getByeGroup($fighters)
    {
        $fighterCount = $fighters->count();
        $firstRoundGroupSize = $this->firstRoundGroupSize(); // Get the size of groups in the first round (2,3,4)
        // Max number of fighters for the first round
        $treeSize = $this->getTreeSize($fighterCount, $firstRoundGroupSize);
        $byeCount = $treeSize - $fighterCount;

        return $this->createByeGroup($byeCount);
    }

    /**
     * Save Groups with their parent info.
     *
     * @param int $numRounds
     * @param int $numFighters
     */
    protected function pushGroups($numRounds, $numFighters)
    {
        // TODO Here is where you should change when enable several winners for preliminary
        for ($roundNumber = 2; $roundNumber <= $numRounds + 1; $roundNumber++) {
            // From last match to first match
            $maxMatches = ($numFighters / pow(2, $roundNumber));

            for ($matchNumber = 1; $matchNumber <= $maxMatches; $matchNumber++) {
                $fighters = $this->createByeGroup(2);
                $group = $this->saveGroup($matchNumber, $roundNumber, null);
                $this->syncGroup($group, $fighters);
            }
        }
        // Third place Group
        if ($numFighters >= $this->championship->getGroupSize() * 2) {
            $fighters = $this->createByeGroup(2);

            $group = $this->saveGroup($maxMatches, $numRounds, null);

            $this->syncGroup($group, $fighters);
        }
    }

    /**
     * Create empty groups after round 1.
     *
     * @param $numFighters
     */
    protected function pushEmptyGroupsToTree($numFighters)
    {
        if ($this->championship->hasPreliminary()) {
            /* Should add * prelimWinner but it add complexity about parent / children in tree
            */
            $numFightersElim = $numFighters / $this->settings->preliminaryGroupSize * 2;
            // We calculate how much rounds we will have
            $numRounds = intval(log($numFightersElim, 2)); // 3 rounds, but begining from round 2 ( ie => 4)
            return $this->pushGroups($numRounds, $numFightersElim);
        }
        // We calculate how much rounds we will have
        $numRounds = $this->getNumRounds($numFighters);

        return $this->pushGroups($numRounds, $numFighters);
    }

    /**
     * Chunk Fighters into groups for fighting, and optionnaly shuffle.
     *
     * @param $fightersByEntity
     *
     * @return Collection|null
     */
    protected function chunk(Collection $fightersByEntity)
    {
        //TODO Should Pull down to know if team or competitor
        if ($this->championship->hasPreliminary()) {
            return (new PlayOffCompetitorTreeGen($this->championship, null))->chunk($fightersByEntity);
        }
        $fightersGroup = $fightersByEntity->chunk(2);

        return $fightersGroup;
    }

    /**
     * Generate First Round Fights.
     */
    protected function generateFights()
    {
        //  First Round Fights
        $settings = $this->settings;
        $initialRound = 1;
        // Very specific case to common case : Preliminary with 3 fighters
        if ($this->championship->hasPreliminary() && $settings->preliminaryGroupSize == 3) {
            // First we make all first fights of all groups
            // Then we make all second fights of all groups
            // Then we make all third fights of all groups
            $groups = $this->championship->groupsByRound(1)->get();
            foreach ($groups as $numGroup => $group) {
                for ($numFight = 1; $numFight <= $settings->preliminaryGroupSize; $numFight++) {
                    $fight = new PreliminaryFight();
                    $order = $numGroup * $settings->preliminaryGroupSize + $numFight;
                    $fight->saveFight2($group, $numFight, $order);
                }
            }
            $initialRound++;
        }
        // Save Next rounds
        $fight = new SingleEliminationFight();
        $fight->saveFights($this->championship, $initialRound);
    }

    /**
     * Return number of rounds for the tree based on fighter count.
     *
     * @param $numFighters
     *
     * @return int
     */
    protected function getNumRounds($numFighters)
    {
        return intval(log($numFighters / $this->firstRoundGroupSize() * 2, 2));
    }

    /**
     * Get the group size for the first row.
     *
     * @return int - return 2 if not preliminary, 3,4,5 otherwise
     */
    private function firstRoundGroupSize()
    {
        return $this->championship->hasPreliminary()
            ? $this->settings->preliminaryGroupSize
            : 2;
    }

    /**
     * Generate all the groups, and assign figthers to group.
     *
     * @throws TreeGenerationException
     */
    protected function generateAllTrees()
    {
        $this->minFightersCheck(); // Check there is enough fighters to generate trees
        $usersByArea = $this->getFightersByArea(); // Get fighters by area (reparted by entities and filled with byes)
        $this->generateGroupsForRound($usersByArea, 1); // Generate all groups for round 1
        $numFighters = count($usersByArea->collapse());
        $this->pushEmptyGroupsToTree($numFighters); // Fill tree with empty groups
        $this->addParentToChildren($numFighters); // Build the entire tree and fill the next rounds if possible
    }

    /**
     * @param Collection $usersByArea
     * @param $round
     */
    public function generateGroupsForRound(Collection $usersByArea, $round)
    {
        $order = 1;
        foreach ($usersByArea as $fightersByEntity) {
            // Chunking to make small round robin groups
            $chunkedFighters = $this->chunk($fightersByEntity);
//            dd($chunkedFighters->toArray());
            foreach ($chunkedFighters as $fighters) {
                $fighters = $fighters->pluck('id');
                $group = $this->saveGroup($order, $round, null);
                $this->syncGroup($group, $fighters);
                $order++;
            }
        }
    }

    /**
     * Check if there is enough fighters, throw exception otherwise.
     *
     * @throws TreeGenerationException
     */
    private function minFightersCheck()
    {
        $fighters = $this->getFighters();
        $areas = $this->settings->fightingAreas;
        $fighterType = $this->championship->category->isTeam
            ? trans_choice('laravel-tournaments::core.team', 2)
            : trans_choice('laravel-tournaments::core.competitor', 2);

        $minFighterCount = $fighters->count() / $areas;

        if ($this->settings->hasPreliminary && $fighters->count() / ($this->settings->preliminaryGroupSize * $areas) < 1) {
            throw new TreeGenerationException(trans('laravel-tournaments::core.min_competitor_required', [
                'number'       => $this->settings->preliminaryGroupSize * $areas,
                'fighter_type' => $fighterType,
            ]), 422);
        }

        if ($minFighterCount < ChampionshipSettings::MIN_COMPETITORS_BY_AREA) {
            throw new TreeGenerationException(trans('laravel-tournaments::core.min_competitor_required', [
                'number'       => ChampionshipSettings::MIN_COMPETITORS_BY_AREA,
                'fighter_type' => $fighterType,
            ]), 422);
        }
    }

    /**
     * Insert byes group alternated with full groups.
     *
     * @param Collection $fighters    - List of fighters
     * @param int        $numByeTotal - Quantity of byes to insert
     *
     * @return Collection - Full list of fighters including byes
     */
private function insertByes(Collection $fighters, int $numByeTotal)
{
    $slots = pow(2, ceil(log(max(1, $fighters->count() + $numByeTotal), 2)));
    $seedOrder = $this->generateTraditionalSeedingOrder($slots);
    $filledSlots = [];

    $seeded = $fighters->filter(fn($f) => $f->seed !== null)->sortBy('seed')->values();
    $unseeded = $fighters->filter(fn($f) => $f->seed === null)->values();

    // Step 1: Place seeded in their slots
    $criticalSlots = [];
    foreach ($seeded as $index => $fighter) {
        $seedSlot = $seedOrder[$index];
        $filledSlots[$seedSlot] = $fighter;

        // determine the slot of its opponent
        $matchIndex = intdiv($seedSlot - 1, 2);
        $slot1 = $matchIndex * 2 + 1;
        $slot2 = $matchIndex * 2 + 2;
        $opponentSlot = ($seedSlot === $slot1) ? $slot2 : $slot1;

        $criticalSlots[] = $opponentSlot;
    }

    // Step 2: Fill critical slots with BYE if we have byes to place
    $bye = $this->createByeFighter();
    foreach ($criticalSlots as $slot) {
        if ($numByeTotal <= 0) {
            break;
        }

        if (!isset($filledSlots[$slot])) {
            $filledSlots[$slot] = $bye;
            $numByeTotal--;
        }
    }

    // Step 3: Fill remaining slots with unseeded fighters
    foreach ($seedOrder as $slot) {
        if (!isset($filledSlots[$slot])) {
            if ($unseeded->isNotEmpty()) {
                $filledSlots[$slot] = $unseeded->shift();
            } elseif ($numByeTotal > 0) {
                $filledSlots[$slot] = $bye;
                $numByeTotal--;
            } else {
                $filledSlots[$slot] = $bye;
            }
        }
    }

    return collect($filledSlots)->sortKeys()->values();
}



    /**
     * @param $frequency
     * @param $groupSize
     * @param $count
     * @param $byeCount
     *
     * @return bool
     */
    private function shouldInsertBye($frequency, $count, $byeCount, $numByeTotal): bool
    {
        return $count != 0 && $count % $frequency == 0 && $byeCount < $numByeTotal;
    }

    /**
     * Method that fills fighters with Bye Groups at the end.
     *
     * @param $fighters
     * @param Collection $fighterGroups
     *
     * @return Collection
     */
public function adjustFightersGroupWithByes($fighters, $fighterGroups): Collection
{
    $tmpFighterGroups = clone $fighterGroups;

    // Hitung jumlah fighter sesudah repart
    $max = $this->getMaxFightersByEntity($tmpFighterGroups);
    $fighters = $this->repart($fighterGroups, $max);

    // Optionally shuffle if not in test
    if (!app()->runningUnitTests()) {
        $fighters = $fighters->shuffle();
    }

    // Hitung slot kelipatan 2 terdekat
    $total = $fighters->count();
    $slots = pow(2, ceil(log(max(1, $total), 2)));

    // Hitung jumlah bye
    $numBye = $slots - $total;

    // Gunakan insertByes yang benar
    $fighters = $this->insertByes($fighters, $numBye);

    return $fighters;
}


    /**
     * Get the biggest entity group.
     *
     * @param $userGroups
     *
     * @return int
     */
    private function getMaxFightersByEntity($userGroups): int
    {
        return $userGroups
            ->sortByDesc(function ($group) {
                return $group->count();
            })
            ->first()
            ->count();
    }

    /**
     * Repart BYE in the tree,.
     *
     * @param $fighterGroups
     * @param int $max
     *
     * @return Collection
     */
    private function repart($fighterGroups, $max)
    {
        $fighters = new Collection();
        for ($i = 0; $i < $max; $i++) {
            foreach ($fighterGroups as $fighterGroup) {
                $fighter = $fighterGroup->values()->get($i);
                if ($fighter != null) {
                    $fighters->push($fighter);
                }
            }
        }

        return $fighters;
    }

    private function generateTraditionalSeedingOrder($slots)
    {
        if ($slots == 2) return [1, 2];

        $order = [1, 2];
        while (count($order) < $slots) {
            $next = [];
            $max = count($order) * 2 + 1;
            foreach ($order as $n) {
                $next[] = $n;
                $next[] = $max - $n;
            }
            $order = $next;
        }
        return $order;
    }
}
