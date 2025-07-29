@php
    $indexA = $match['indexA'] ?? 0;
    $indexB = $match['indexB'] ?? 1;

    // Cocokan winner_id dengan playerA dan playerB
    $isAWinner = isset($scores[$indexA]) && optional($match['playerA'])->id == $scores[$indexA] ? 'X' : null;
    $isBWinner = isset($scores[$indexB]) && optional($match['playerB'])->id == $scores[$indexB] ? 'X' : null;
@endphp

<style>
.player-line {
    align-items: center;
    max-width: 100%;
}

.player-name {
    flex: 1;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

</style>

<div class="match-wrapper"
     style="top: {{ $match['matchWrapperTop'] }}px; left: {{ $match['matchWrapperLeft'] }}px; width: {{ $treeGen->matchWrapperWidth }}px;">

    <div class="player-line {{ $isAWinner ? 'bg-success' : '' }}">
        <input type="text" class="score" name="score[]" value="{{ $isAWinner ? optional($match['playerA'])->id : '' }}">
        <div class="player-name">
            @include('dashboard.champs.setting.partials.tree.brackets.playerList', [
                'selected' => $match['playerA'],
                'roundNumber' => $roundNumber,
                'isSuccess' => $isAWinner
            ])
        </div>
    </div>

    <div class="match-divider"></div>

    <div class="player-line {{ $isBWinner ? 'bg-success' : '' }}">
        <input type="text" class="score" name="score[]" value="{{ $isBWinner ? optional($match['playerB'])->id : '' }}">
        <div class="player-name">
            @include('dashboard.champs.setting.partials.tree.brackets.playerList', [
                'selected' => $match['playerB'],
                'roundNumber' => $roundNumber,
                'isSuccess' => $isBWinner
            ])
        </div>
    </div>
</div>

