<?php

namespace Xoco70\LaravelTournaments\TreeGen;

use Xoco70\LaravelTournaments\Models\Competitor;
use Xoco70\LaravelTournaments\Models\Team;
use Xoco70\LaravelTournaments\Models\FightersGroup;
use Xoco70\LaravelTournaments\Models\Fight;
use Illuminate\Support\Collection;

class CreateSingleEliminationTree
{
    public $groupsByRound;
    public $hasPreliminary;
    public $brackets = [];
    public $championship;
    public $numFighters;
    public $noRounds;
    public $playerWrapperHeight = 30;
    public $matchWrapperWidth = 150;
    public $roundSpacing = 40;
    public $matchSpacing = 42;
    public $borderWidth = 3;

    public function __construct($groupsByRound, $championship, $hasPreliminary)
    {
        $this->championship = $championship;
        $this->groupsByRound = $groupsByRound;
        $this->hasPreliminary = $hasPreliminary;
    }
    public function build()
    {
        $roundNumber = 1;

        /** 
         * Step 1: Ambil semua fighter di round 1 
         * → termasuk fighter yang bertemu bye
         */
        $groups = $this->groupsByRound->get($roundNumber) ?? collect();

        $fighters = collect();
        $fightersById = collect();
        $fightersWonByBye = collect();

        foreach ($groups as $group) {
            $fight = $group->fights->first();

            if (!$fight) {
                continue;
            }

            $fighter1 = $fight->fighter1;
            $fighter2 = $fight->fighter2;

            // cek siapa yang BYE
            if ($this->isBye($fighter1) && !$this->isBye($fighter2)) {
                // fighter2 menang otomatis
                $this->setWinner($fight, $fighter2);
                $fightersWonByBye->push($fighter2->id);
                continue; // Ini di sini
            } elseif ($this->isBye($fighter2) && !$this->isBye($fighter1)) {
                $this->setWinner($fight, $fighter1);
                $fightersWonByBye->push($fighter1->id);
                continue; // Dan di sini
            } else {
                // match normal → keduanya masuk round 1
                if ($fighter1) {
                    $fighters->push($fighter1);
                    $fightersById->put($fighter1->id, $fighter1);
                }
                if ($fighter2) {
                    $fighters->push($fighter2);
                    $fightersById->put($fighter2->id, $fighter2);
                }
            }
        }

        /**
         * Step 2:
         * Ambil semua fighter dari fighter groups (getFightersWithBye),
         * lalu masukkan ke list fighter jika belum ada
         */
        $allFighters = $this->groupsByRound->first()->flatMap(function ($group) {
            return $group->getFightersWithBye();
        })->filter();

        foreach ($allFighters as $fighter) {
            if (!$fightersById->has($fighter->id)) {
                // tambahkan fighter yang menang bye → akan bertanding di round 2
                $fighters->push($fighter);
                $fightersById->put($fighter->id, $fighter);
            }
        }

        // Update jumlah fighter
        $this->numFighters = $fighters->count();

        $this->noRounds = $this->numFighters > 0
            ? log($this->numFighters, 2)
            : 0;

        /**
         * Step 3:
         * Buat matches untuk round 1
         */
        $matches = array_chunk($fighters->all(), 2);

        foreach ($matches as $index => $match) {
            $fighter1 = $match[0] ?? null;
            $fighter2 = $match[1] ?? null;

            $this->brackets[$roundNumber][$index + 1] = [$fighter1, $fighter2];
        }

        $this->assignFightersToBracket($roundNumber, $this->hasPreliminary);
        $this->assignPositions();

        if ($this->numFighters >= $this->championship->getGroupSize() * 2) {
            $this->brackets[$this->noRounds][2]['matchWrapperTop'] =
                $this->brackets[$this->noRounds][1]['matchWrapperTop'] + 100;
        }
    }


    private function setWinner($fight, $fighter)
    {
        $fight->winner_id = $fighter->id;
        $fight->save();
    }

    private function isBye($fighter): bool
    {
        return $fighter === null || ($fighter?->is_bye ?? false);
    }

    // public function build()
    // {
    //     $fighters = $this->groupsByRound->first()->map(function ($item) {
    //         $fighters = $item->getFightersWithBye();
    //         $fighter1 = $fighters->get(0);
    //         $fighter2 = $fighters->get(1);

    //         return [$fighter1, $fighter2];
    //     })->flatten()->all();
    //     $this->numFighters = count($fighters);

    //     //Calculate the size of the first full round - for example if you have 5 fighters, then the first full round will consist of 4 fighters
    //     $this->noRounds = log($this->numFighters, 2);
    //     $roundNumber = 1;

    //     //Group 2 fighters into a match
    //     $matches = array_chunk($fighters, 2);

    //     //If there's already a match in the match array, then that means the next round is round 2, so increase the round number
    //     if (count($this->brackets)) {
    //         $roundNumber++;
    //     }
    //     $countMatches = count($matches);
    //     //Create the first full round of fighters, some may be blank if waiting on the results of a previous round
    //     for ($i = 0; $i < $countMatches; $i++) {
    //         $this->brackets[$roundNumber][$i + 1] = $matches[$i];
    //     }

    //     //Create the result of the empty rows for this tournament
    //     $this->assignFightersToBracket($roundNumber, $this->hasPreliminary);
    //     $this->assignPositions();

    //     if ($this->numFighters >= $this->championship->getGroupSize() * 2) {
    //         $this->brackets[$this->noRounds][2]['matchWrapperTop'] = $this->brackets[$this->noRounds][1]['matchWrapperTop'] + 100;
    //     }
    // }


    private function assignPositions()
    {
        $spaceFactor = 0.5;
        $playerHeightFactor = 1;

        foreach ($this->brackets as $roundNumber => &$round) {
            foreach ($round as $matchNumber => &$match) {
                $match['playerA'] = $match[0] ?? null;
                $match['playerB'] = $match[1] ?? null;
                $match['winner_id'] = $match[2] ?? null;

                unset($match[0], $match[1], $match[2]);

                $match['matchWrapperTop'] = (((2 * $matchNumber) - 1) * (pow(2, ($roundNumber) - 1)) - 1) *
                    (($this->matchSpacing / 2) + $this->playerWrapperHeight);

                $match['matchWrapperLeft'] = ($roundNumber - 1) *
                    ($this->matchWrapperWidth + $this->roundSpacing - 1);

                $match['vConnectorLeft'] = floor(
                    $match['matchWrapperLeft'] +
                    $this->matchWrapperWidth +
                    ($this->roundSpacing / 2) -
                    ($this->borderWidth / 2)
                );

                $match['vConnectorHeight'] =
                    ($spaceFactor * $this->matchSpacing) +
                    ($playerHeightFactor * $this->playerWrapperHeight) +
                    $this->borderWidth;

                $match['vConnectorTop'] = $match['hConnectorTop'] =
                    $match['matchWrapperTop'] + $this->playerWrapperHeight;

                $match['hConnectorLeft'] =
                    ($match['vConnectorLeft'] - ($this->roundSpacing / 2)) + 2;

                $match['hConnector2Left'] =
                    $match['matchWrapperLeft'] +
                    $this->matchWrapperWidth +
                    ($this->roundSpacing / 2);

                if (!($matchNumber % 2)) {
                    $match['hConnector2Top'] = $match['vConnectorTop'] -=
                        ($match['vConnectorHeight'] - $this->borderWidth);
                } else {
                    $match['hConnector2Top'] = $match['vConnectorTop'] +
                        ($match['vConnectorHeight'] - $this->borderWidth);
                }
            }

            $spaceFactor *= 2;
            $playerHeightFactor *= 2;
        }
    }

    /**
     * Print Round Titles.
     */
    public function printRoundTitles()
    {
        $roundTitles = $this->getRoundTitles();

        echo '<div id="round-titles-wrapper">';
        foreach ($roundTitles as $key => $roundTitle) {
            $left = $key * ($this->matchWrapperWidth + $this->roundSpacing - 1);
            echo '<div class="round-title" style="left: '.$left.'px;">'.$roundTitle.'</div>';
        }
        echo '</div>';
    }

    public function getRoundTitles()
    {
        if ($this->numFighters > 8) {
            $roundTitles = ['Quarter-Finals', 'Semi-Finals', 'Final'];
            $noRounds = ceil(log($this->numFighters, 2));
            $noTeamsInFirstRound = pow(2, ceil(log($this->numFighters, 2)));
            $tempRounds = [];

            for ($i = 0; $i < $noRounds - 3; $i++) {
                $tempRounds[] = 'Last '.$noTeamsInFirstRound;
                $noTeamsInFirstRound /= 2;
            }

            return array_merge($tempRounds, $roundTitles);
        }

        $roundTitle = [
            2 => ['Final'],
            3 => ['Semi-Finals', 'Final'],
            4 => ['Semi-Finals', 'Final'],
            5 => ['Semi-Finals', 'Final'],
            6 => ['Quarter-Finals', 'Semi-Finals', 'Final'],
            7 => ['Quarter-Finals', 'Semi-Finals', 'Final'],
            8 => ['Quarter-Finals', 'Semi-Finals', 'Final'],
        ];

        return $roundTitle[$this->numFighters] ?? [];
    }

    /**
     * @param $selected
     *
     * @return string
     */
    public function getPlayerList($selected)
    {
        $html = '<select>
                <option'.($selected == '' ? ' selected' : '').'></option>';

        foreach ($this->championship->fighters as $fighter) {
            $html = $this->addOptionToSelect($selected, $fighter, $html);
        }

        $html .= '</select>';

        return $html;
    }

    public function getNewFighter()
    {
        if ($this->championship->category->isTeam()) {
            return new Team();
        }

        return new Competitor();
    }

    /**
     * @param $numRound
     */
    private function assignFightersToBracket($numRound, $hasPreliminary)
    {
        for ($roundNumber = $numRound; $roundNumber <= $this->noRounds; $roundNumber++) {
            $groupsByRound = $this->groupsByRound->get($roundNumber + $hasPreliminary);
            for ($matchNumber = 1; $matchNumber <= ($this->numFighters / pow(2, $roundNumber)); $matchNumber++) {
                $fight = $groupsByRound[$matchNumber - 1]->fights[0];
                $fighter1 = $fight->fighter1;
                $fighter2 = $fight->fighter2;
                $winnerId = $fight->winner_id;
                $this->brackets[$roundNumber][$matchNumber] = [$fighter1, $fighter2, $winnerId];
            }
        }

        if ($this->numFighters >= $this->championship->getGroupSize() * 2) {
            $lastRound = $this->noRounds;
            $lastMatch = $this->numFighters / pow(2, $roundNumber) + 1;
            $groupsByRound = $this->groupsByRound->get(intval($this->noRounds));
            $group = $groupsByRound[$lastMatch];
            $fight = $group->fights[0];
            $fighter1 = $fight->fighter1;
            $fighter2 = $fight->fighter2;
            $winnerId = $fight->winner_id;
            $this->brackets[$lastRound][$lastMatch + 1] = [$fighter1, $fighter2, $winnerId];
        }
    }

    /**
     * @param $selected
     * @param $fighter
     * @param $html
     *
     * @return string
     */
    private function addOptionToSelect($selected, $fighter, $html): string
    {
        if ($fighter != null) {
            $select = $selected != null && $selected->id == $fighter->id ? ' selected' : '';
            $html .= '<option'.$select
                .' value='
                .($fighter->id ?? '')
                .'>'
                .$fighter->name
                .'</option>';
        }

        return $html;
    }
}
