@foreach($championship->fights()->get()->groupBy('area') as $fightsByArea)
    <h4 class="mt-4">Area {{ $fightsByArea->get(0)->area }}</h4>

    <div class="table-responsive">
        <table class="table table-bordered text-center align-middle">

            <thead class="table-light">
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Competitor 1</th>
                    <th scope="col">Skor 1</th> <!-- Tambahan -->
                    <th scope="col">Competitor 2</th>
                    <th scope="col">Skor 2</th> <!-- Tambahan -->
                    <th scope="col">Pilih Pemenang</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @php $fightId = 0; @endphp
                @foreach($fightsByArea as $fight)
                    @if ($fight->shouldBeInFightList(false))
                        @php
                            $fighter1 = $fight->fighter1;
                            $fighter2 = $fight->fighter2;
                            $fightId++;
                        @endphp
                        <tr>
                            <td>{{ $fightId }}</td>
                            <td>{{ $fighter1?->fullName ?? 'BYE' }}</td>
                            <td>{{ $fight->score_c1 ?? '-' }}</td> <!-- Tampilkan skor fighter1 -->
                            <td>{{ $fighter2?->fullName ?? 'BYE' }}</td>
                            <td>{{ $fight->score_c2 ?? '-' }}</td> <!-- Tampilkan skor fighter2 -->
                            <td>
                                <form action="/dashboard/champs/{{ $championship->id }}/fight/{{ $fight->id }}" method="POST" class="d-flex justify-content-center">
                                    @csrf
                                    @method('PUT')
                                    <select name="winner_id" class="form-select form-select-sm w-auto">
                                        <option value="">-- Pilih --</option>
                                        @if($fighter1)
                                            <option value="{{ $fighter1->id }}" {{ $fight->winner_id == $fighter1->id ? 'selected' : '' }}>
                                                {{ $fighter1->fullName }}
                                            </option>
                                        @endif
                                        @if($fighter2)
                                            <option value="{{ $fighter2->id }}" {{ $fight->winner_id == $fighter2->id ? 'selected' : '' }}>
                                                {{ $fighter2->fullName }}
                                            </option>
                                        @endif
                                    </select>
                            </td>
                            <td>
                                    <button type="submit" class="btn btn-sm btn-success">Simpan</button>
                                </form>
                            </td>
                        </tr>
                    @endif
                @endforeach
            </tbody>

        </table>
    </div>
@endforeach
