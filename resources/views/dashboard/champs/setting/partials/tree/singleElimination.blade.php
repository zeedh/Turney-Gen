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

<style>
    #brackets-wrapper {
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
    }
    .vertical-connector, .horizontal-connector {
        z-index: 0;
    }

</style>

@if ($treeGen)
    @if (Request::is('championships/'.$championship->id.'/pdf'))
        <h1 class="h5 mb-3">{{ $championship->buildName() }}</h1>
    @endif

    <form method="POST" action="/dashboard/champs/{{ $champ->id }}/setting/{{ $champ->settings->id }}" accept-charset="UTF-8">
        @csrf
        @method('PUT')
        <input type="hidden" id="activeTreeTab" name="activeTreeTab" value="{{ $championship->id }}"/>

        {{-- Round Titles --}}
        <div class="overflow-x-auto mb-3">
            {!! $treeGen->printRoundTitles() !!}
        </div>

        {{-- Bracket Wrapper --}}
        <div class="overflow-x-auto">
            <div id="brackets-wrapper"
                class="position-relative"
                style="min-width: 700px; padding-bottom: {{ ($championship->groupsByRound(1)->count() / 2 * 205) }}px">
                
                @foreach ($treeGen->brackets as $roundNumber => $round)
                    @foreach ($round as $matchNumber => $match)
                        @include('dashboard.champs.setting.partials.tree.brackets.fight')

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
        </div>

        <div class="clearfix"></div>

        <div class="text-end mt-4">
            <button type="submit" class="btn btn-success" id="update">
                Update Tree
            </button>
        </div>
    </form>
@endif
