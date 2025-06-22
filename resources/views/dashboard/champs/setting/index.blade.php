@extends('dashboard.champs.layouts.main')

@section('container')
@php
    $isTeam = session('isTeam', 0);
    $championship = $tournament->championships[$isTeam];
    $setting = $championship->getSettings();
    $treeType = $setting->treeType ?? 0;
    $hasPreliminary = $setting->hasPreliminary ?? 0;
    $fightingAreas = $setting->fightingAreas ?? 1;
    $fights = $championship->fights;
    $numFighters = session('numFighters', $champ->competitors->count());

            $rounds = $championship->fightersGroups->groupBy('round');
        $finalGroup = $rounds->max();
        $finalFight = optional($rounds->last())->first()?->fights?->first();

        $winner = $finalFight?->winner;
        $loser = null;
        if ($finalFight?->winner_id && $finalFight?->c1 && $finalFight?->c2) {
            $loser = $finalFight->winner_id == $finalFight->c1 ? $finalFight->c2 : $finalFight->c1;
        }

        // Ambil semifinal untuk tentukan juara 3
        $semiGroups = $rounds->get($finalGroup->first()->round - 1) ?? collect();
        $semiLosers = [];

        foreach ($semiGroups as $semi) {
            $fight = $semi->fights->first();
            if (!$fight || !$fight->winner_id || !$fight->c1 || !$fight->c2) continue;

            $loserId = $fight->winner_id == $fight->c1 ? $fight->c2 : $fight->c1;
            if ($loserId != $loser) {
                $semiLosers[] = $loserId;
            }
        }

        $juara3 = \Xoco70\LaravelTournaments\Models\Competitor::find($semiLosers);
        $juara2 = \Xoco70\LaravelTournaments\Models\Competitor::find($loser);
@endphp

<div class="container-fluid px-3">
  <div class="row">
    <div class="col-12 col-lg-12 mx-auto">

      @include('dashboard.champs.setting.partials.errors')
      @include('dashboard.champs.setting.partials.settings')

      @if ($championship->fightersGroups->count() > 0)

        <!-- Tree Section -->
        <div class="card shadow-sm mb-4">
          <div class="card-header bg-success text-white">
            <h5 class="mb-0">Tournament Tree</h5>
          </div>
          <div class="card-body overflow-auto">
            @if ($championship->hasPreliminary())
              @include('dashboard.champs.setting.partials.tree.preliminary')
            @else
              @if ($championship->isSingleEliminationType())
                @include('dashboard.champs.setting.partials.tree.singleElimination', ['hasPreliminary' => 0])
              @elseif ($championship->isPlayOffType())
                @include('dashboard.champs.setting.partials.tree.playOff')
              @else
                <div class="alert alert-danger mb-0" role="alert">
                  <strong>Oops!</strong> There seems to be a problem with the championship type.
                </div>
              @endif
            @endif

            <!-- Champion Results -->
            <div class="card-header bg-info text-white ">
              <h5 class="mb-0">Peringkat Juara</h5>
            </div>
              <table class="table table-bordered text-center mb-0">
                <thead class="table-light">
                  <tr>
                    <th>Peringkat</th>
                    <th>Nama</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td><strong>Juara 1</strong></td>
                    <td>{{ $winner?->fullName ?? '-' }}</td>
                  </tr>
                  <tr>
                    <td><strong>Juara 2</strong></td>
                    <td>{{ $juara2?->fullName ?? '-' }}</td>
                  </tr>
                  @foreach($juara3 as $third)
                    <tr>
                      <td><strong>Juara 3</strong></td>
                      <td>{{ $third->fullName ?? '-' }}</td>
                    </tr>
                  @endforeach
                </tbody>
              </table>

          </div>
        </div>

        <!-- Fight List Section -->
        <div class="card shadow-sm mb-5">
          <div class="card-header bg-warning text-dark">
            <h5 class="mb-0">Fight List</h5>
          </div>
          <div class="card-body text-center table-responsive">
            @include('dashboard.champs.setting.partials.fights')
          </div>
        </div>

      @endif
    </div>
  </div>
</div>

<script>
  var treeValue = {{ $treeType }};
  var preliminaryValue = {{ $hasPreliminary }};

  new Vue({
    el: '#app',
    data: {
      isPrelimDisabled: false,
      isGroupSizeDisabled: false,
      isAreasDisabled: false,
      hasPrelim: 0,
      tree: 1,
    },
    methods: {
      prelim() {
        this.isGroupSizeDisabled = this.hasPrelim == 0;
      },
      treeType() {
        this.isPrelimDisabled = this.tree == 0;
        this.isAreasDisabled = this.tree == 0;
      }
    },
    created() {
      this.tree = treeValue;
      this.hasPrelim = preliminaryValue;
      this.prelim();
      this.treeType();
    }
  })
</script>
@endsection
