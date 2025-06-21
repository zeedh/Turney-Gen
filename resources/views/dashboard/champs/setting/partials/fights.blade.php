@foreach($championship->fights()->get()->groupBy('area') as $fightsByArea)
    <h4 class="mt-4">Area {{ $fightsByArea->get(0)->area }}</h4>

    <div class="table-responsive">
        <table class="table table-bordered text-center align-middle">
            <thead class="table-light">
                <tr>    
                    <th scope="col">Pemain 1</th>
                    <th scope="col">Skor 1</th>
                    <th scope="col">Skor 2</th>
                    <th scope="col">Pemain 2</th>
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
                            $winnerId = $fight->winner_id;
                        @endphp
                        <tr>
                            <td class="{{ $winnerId === $fight->c1 ? 'table-success' : '' }}">
                                {{ $fighter1?->fullName ?? 'BYE' }}
                            </td>
                            <td class="{{ $winnerId === $fight->c1 ? 'table-success' : '' }}">
                                {{ $fight->score_c1 ?? '-' }}
                            </td>
                            <td class="{{ $winnerId === $fight->c2 ? 'table-success' : '' }}">
                                {{ $fight->score_c2 ?? '-' }}
                            </td>
                            <td class="{{ $winnerId === $fight->c2 ? 'table-success' : '' }}">
                                {{ $fighter2?->fullName ?? 'BYE' }}
                            </td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>
@endforeach
