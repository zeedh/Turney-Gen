<form method="POST" action="{{ route('dashboard.setting.index', ['champ' => $champ->id, 'setting' => $champ->settings->id])}}" accept-charset="UTF-8" class="form-settings">
    @csrf

    <div class="card shadow-sm mb-4">
        <div class="card-header bg-danger text-white">
            <h5 class="mb-0">Pengaturan Bagan</h5>
        </div>
        <div class="card-body">

            <div class="row g-4">
                <!-- Preliminary -->
                <div class="col-lg-4">
                    <label for="hasPreliminary" class="form-label">Preliminary</label>
                    <select class="form-select" id="hasPreliminary" name="hasPreliminary"
                        :disabled="isPrelimDisabled" v-model="hasPrelim" v-on:change="prelim()">
                        <option value="0" {{ $hasPreliminary == 0 ? 'selected' :'' }}>NO</option>
                        <option value="1" {{ $hasPreliminary == 1 ? 'selected' :'' }}>YES</option>
                    </select>
                </div>

                <!-- Preliminary Group Size -->
                <div class="col-lg-4">
                    <label for="preliminaryGroupSize" class="form-label">{{ trans('laravel-tournaments::core.preliminaryGroupSize') }}</label>
                    <select class="form-select" id="preliminaryGroupSize" name="preliminaryGroupSize" :disabled="isGroupSizeDisabled">
                        <option value="3" @if ($setting->preliminaryGroupSize == 3) selected @endif>3</option>
                        <option value="4" @if ($setting->preliminaryGroupSize == 4) selected @endif>4</option>
                        <option value="5" @if ($setting->preliminaryGroupSize == 5) selected @endif>5</option>
                    </select>
                </div>

                <!-- Max Fighters -->
                <!-- <div class="col-lg-4">
                    <label for="numFighters" class="form-label">Maksimal Jumlah Pemain</label>
                    <select class="form-select" id="numFighters" name="numFighters">
                        @for ($i = 2; $i <= 7; $i++)
                            @php $val = pow(2, $i); @endphp
                            <option value="{{ $val }}" @if ($numFighters == $val) selected @endif>{{ $val }}</option>
                        @endfor
                    </select>
                </div> -->
                <input type="hidden" name="numFighters" value="{{ $champ->competitors->count() }}">


                <!-- Team -->
                <div class="col-lg-4">
                    <label for="isTeam" class="form-label">Team?</label>
                    <select class="form-select" id="isTeam" name="isTeam">
                        <option value="0" {{ $isTeam == 0 ? 'selected' :'' }}>NO</option>
                        <option value="1" {{ $isTeam == 1 ? 'selected' :'' }}>YES</option>
                    </select>
                </div>

                <!-- Tree Type -->
                <div class="col-lg-4">
                    <label for="treeType" class="form-label">Tree Type</label>
                    <select class="form-select" id="treeType" name="treeType" v-model="tree" v-on:change="treeType()">
                        <option value="0" @if ($setting->treeType == 0) selected @endif>{{ trans('laravel-tournaments::core.playoff') }}</option>
                        <option value="1" @if ($setting->treeType == 1) selected @endif>{{ trans('laravel-tournaments::core.single_elimination') }}</option>
                    </select>
                </div>

                <!-- Fighting Areas -->
                <div class="col-lg-4">
                    <label for="fightingAreas" class="form-label">{{ trans_choice('laravel-tournaments::core.fightingArea',2) }}</label>
                    <select class="form-select" id="fightingAreas" name="fightingAreas" :disabled="isAreaDisabled">
                        <option value="1" @if ($setting->fightingAreas == 1) selected @endif>1</option>
                        <option value="2" @if ($setting->fightingAreas == 2) selected @endif>2</option>
                        <option value="4" @if ($setting->fightingAreas == 4) selected @endif>4</option>
                        <option value="8" @if ($setting->fightingAreas == 8) selected @endif>8</option>
                    </select>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="d-flex justify-content-end mt-4">
                <button type="submit" class="btn btn-success" id="save">
                    <i class="bi bi-diagram-3-fill me-1"></i> Generate Tree
                </button>
            </div>

        </div>
    </div>
</form>
