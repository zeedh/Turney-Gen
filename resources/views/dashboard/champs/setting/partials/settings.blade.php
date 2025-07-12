<div class="alert alert-info shadow-sm mx-4 my-4" role="alert">
    <i class="bi bi-lightbulb-fill me-2 fs-4"></i>
        Anda bisa menekan tombol <strong>Generate Tree</strong> lagi untuk mengulang seluruh bagan pertandingan.
        <br>
        <br>
        <small>
            <strong>Catatan:</strong> Saat membuat bagan dengan jumlah peserta yang tidak genap kelipatan 2
            (misalnya bukan 4, 8, 16, dst), ada kemungkinan bagan yang dihasilkan menjadi <span class="text-danger fw-bold">cacat</span>.
            Mohon untuk menekan tombol <strong>Generate Tree</strong> kembali hingga bagan yang dihasilkan sempurna.
        </small>
</div>

<form method="POST" action="{{ route('dashboard.setting.index', ['champ' => $champ->id, 'setting' => $champ->settings->id]) }}"
      accept-charset="UTF-8" class="mt-4">
    @csrf


        <div class="card-body my-3">

            {{-- Kumpulan hidden input --}}
            <input type="hidden" name="hasPreliminary" value="0">
            <input type="hidden" name="numFighters" value="{{ $champ->competitors->count() }}">
            <input type="hidden" name="isTeam" value="0">
            <input type="hidden" name="treeType" value="1">
            <input type="hidden" name="fightingAreas" value="{{ $champ->settings->fightingAreas ?? 2 }}">

            <div class="text-center">
                <button type="submit" class="btn btn-lg btn-primary">
                    <i class="bi bi-diagram-3-fill me-2"></i> Generate Tree
                </button>
            </div>
        </div>

</form>
