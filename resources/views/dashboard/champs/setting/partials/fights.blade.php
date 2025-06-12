@foreach($championship->fights()->get()->groupBy('area') as $fightsByArea)
    <h4 class="mt-4">Area {{ $fightsByArea->get(0)->area }}</h4>

    <div class="table-responsive">
        <table class="table table-bordered text-center align-middle">
            <thead class="table-light">
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Competitor 1</th>
                    <th scope="col">Competitor 2</th>
                </tr>
            </thead>
            <tbody>
                @php $fightId = 0; @endphp
                @foreach($fightsByArea as $fight)
                    @if ($fight->shouldBeInFightList(false))
                        @php
                            $fighter1 = optional($fight->fighter1)->fullName ?? "BYE";
                            $fighter2 = optional($fight->fighter2)->fullName ?? "BYE";
                            $fightId++;
                        @endphp
                        <tr>
                            <td>{{ $fightId }}</td>
                            <td>{{ $fighter1 }}</td>
                            <td>{{ $fighter2 }}</td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>
@endforeach
