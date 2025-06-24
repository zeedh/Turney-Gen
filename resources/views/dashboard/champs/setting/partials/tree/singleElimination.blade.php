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
    .vertical-connector, .horizontal-connector {
        z-index: 0;
    }
    .round-titles-sticky {
        position: sticky;
        top: 0;
        z-index: 100;
    }

        #brackets-wrapper {
        position: relative;
        width: 100%;
        padding-bottom: {{ ($championship->groupsByRound(1)->count() / 2 * 205) }}px;
    }

    @media (max-width: 768px) {
        #brackets-wrapper {
            overflow-x: auto;
            min-width: 900px;
        }
    }

    @media (min-width: 769px) {
        #brackets-wrapper {
            overflow-x: visible;
        }
    }

    .vertical-connector, .horizontal-connector {
        z-index: 0;
    }

    .round-titles-sticky {
        position: sticky;
        top: 0;
        z-index: 100;
    }

</style>

@if ($treeGen)
    @if (Request::is('championships/'.$championship->id.'/pdf'))
        <h1 class="h5 mb-3">{{ $championship->buildName() }}</h1>
    @endif

    <form id="updateForm" method="POST" action="/dashboard/champs/{{ $champ->id }}/setting/{{ $champ->settings->id }}" accept-charset="UTF-8">
        @csrf
        @method('PUT')
        <input type="hidden" id="activeTreeTab" name="activeTreeTab" value="{{ $championship->id }}"/>

        
        {{-- Bracket Wrapper --}}
        <div class="overflow-x-auto">
            
            {{-- Round Titles --}}
            <div class="round-titles-sticky bg-white border-bottom py-2">
                {!! $treeGen->printRoundTitles() !!}
            </div>

            <div id="brackets-wrapper" class="position-relative">
                
                @foreach ($treeGen->brackets as $roundNumber => $round)
                    @foreach ($round as $matchNumber => $match)
                        @include('dashboard.champs.setting.partials.tree.brackets.fight')

                        @if ($roundNumber != $treeGen->noRounds)
                            {{-- Vertical Connector --}}
                            <div class="vertical-connector"
                                style="top: {{ $match['vConnectorTop'] }}px;
                                        left: {{ $match['vConnectorLeft'] }}px;
                                        height: {{ $match['vConnectorHeight'] }}px;">
                            </div>

                            {{-- Horizontal Connectors --}}
                            <div class="horizontal-connector"
                                style="top: {{ $match['hConnectorTop'] }}px;
                                        left: {{ $match['hConnectorLeft'] }}px;">
                            </div>
                            <div class="horizontal-connector"
                                style="top: {{ $match['hConnector2Top'] }}px;
                                        left: {{ $match['hConnector2Left'] }}px;">
                            </div>
                        @endif
                    @endforeach
                @endforeach
            </div>
        </div>


        <div class="clearfix">
            <div class="text-end mt-4">
                <button type="submit" class="btn btn-success" id="update">
                    Update Tree
                </button>
            </div>

        </div>

    </form>

    {{-- Script konfirmasi --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('updateForm');
            if (form) {
                form.addEventListener('submit', function (e) {
                    const confirmed = confirm("Anda yakin? Hasil Pertandingan tidak dapat diubah lagi setelah dimasukkan!");
                    if (!confirmed) {
                        e.preventDefault();
                    }
                });
            }
        });
    </script>
@endif
