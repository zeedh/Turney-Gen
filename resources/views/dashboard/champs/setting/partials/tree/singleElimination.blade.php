@php
    use Xoco70\LaravelTournaments\TreeGen\CreateSingleEliminationTree;

    $singleEliminationTree = $championship->fightersGroups
        ->where('round', '>=', $hasPreliminary + 1)
        ->groupBy('round');

    $treeGen = null;

    if ($singleEliminationTree->count() > 0) {
        $treeGen = new CreateSingleEliminationTree($singleEliminationTree, $championship, $hasPreliminary);
        $treeGen->build();
    }
@endphp

@if ($treeGen)
    @if (Request::is('championships/'.$championship->id.'/pdf'))
        <h1>{{ $championship->buildName() }}</h1>
    @endif

    <form method="POST" action="{{ route('setting.index', ['champ' => $champ->id])}}" accept-charset="UTF-8">
        @csrf
        @method('PUT')
        <input type="hidden" id="activeTreeTab" name="activeTreeTab" value="{{ $championship->id }}"/>
        
        {{-- Render Round Titles --}}
        {!! $treeGen->printRoundTitles() !!}

        <div id="brackets-wrapper"
             style="padding-bottom: {{ ($championship->groupsByRound(1)->count() / 2 * 205) }}px">
            @foreach ($treeGen->brackets as $roundNumber => $round)
                @foreach ($round as $matchNumber => $match)
                    @include('laravel-tournaments::partials.tree.brackets.fight')

                    @if ($roundNumber != $treeGen->noRounds)
                        {{-- Vertical Connector --}}
                        <div class="vertical-connector"
                             style="top: {{ $match['vConnectorTop'] }}px;
                                    left: {{ $match['vConnectorLeft'] }}px;
                                    height: {{ $match['vConnectorHeight'] }}px;"></div>

                        {{-- Horizontal Connectors --}}
                        <div class="horizontal-connector"
                             style="top: {{ $match['hConnectorTop'] }}px;
                                    left: {{ $match['hConnectorLeft'] }}px;"></div>
                        <div class="horizontal-connector"
                             style="top: {{ $match['hConnector2Top'] }}px;
                                    left: {{ $match['hConnector2Left'] }}px;"></div>
                    @endif
                @endforeach
            @endforeach
        </div>

        <div class="clearfix"></div>
        <div class="text-end mt-3">
            <button type="submit" class="btn btn-success" id="update">
                Update Tree
            </button>
        </div>
    </form>
@endif
