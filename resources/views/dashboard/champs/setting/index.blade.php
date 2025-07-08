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

@endphp

<div class="container-fluid px-3">
  <div class="row">
    <div class="col-12 col-lg-12 mx-auto">

@if($tournament->user_id === auth()->id())
    @include('dashboard.champs.setting.partials.errors')
    @include('dashboard.champs.setting.partials.settings')
@endif


      @if ($championship->fightersGroups->count() > 0)

        <!-- Tree Section -->
        <div class="card shadow-sm mb-4">
          <div class="card-header bg-success text-white">
            <h5 class="mb-0">Tournament Tree</h5>
          </div>
                      <!-- Champion Results -->
            <div class="card-body col-lg-4  ">
              <table class="table table-bordered table-responsive text-center">
                <thead class="table-dark">
                  <tr>
                    <th>Juara</th>
                    <th>Nama</th>
                  </tr>
                </thead>
                <tbody>
                  <tr class="table-warning">
                    <td>Juara 1</td>
                    <td>{{ $champion->fullName ?? '-' }}</td>
                  </tr>

                  <tr class="table-secondary">
                    <td>Juara 2</td>
                    <td>{{ $runnerUp->fullName ?? '-' }}</td>
                  </tr>

                  <tr class="table-light">
                    <td>Juara 3</td>
                    <td>{{ $thirdPlace->fullName ?? '-' }}</td>
                  </tr>

                </tbody>
              </table>
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

        <!-- Fight List Section -->
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
