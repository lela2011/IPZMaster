<x-iframe-layout>
    <h2 class="TextImage--title  richtext">Mitarbeitende</h2>
    <div class="TextImage--inner">
        <div class="TextImage--content richtext">
            @foreach ($orderIds as $orderId)
                @php
                    $type = $types->firstWhere('order', $orderId);
                    $employees = $employeesByType[$orderId] ?? [];
                    $guests = $guestsByType[$orderId] ?? [];
                @endphp
                <P>
                    <strong>{{ $type->german }}</strong>
                    <br>
                    @foreach ($employees as $employee)
                        <a href="{{ $type->url_german  . ($type->has_personal_page ? $employee->uid : '') }}" target="_blank">{{ $employee->first_name }} {{ $employee->last_name }}</a>
                        @if(!$loop->last)
                            <br>
                        @endif
                    @endforeach
                    @if(count($guests) == 0)
                        <br>
                    @endif
                    @foreach ($guests as $guest)
                        @if($guest->url)
                            <a href="{{ $guest->url }}">{{ $guest->name }} ({{ $guest->organization }})</a>
                        @else
                            <a href="mailto:{{ $guest->email }}">{{ $guest->name }} ({{ $guest->organization }})</a>
                        @endif
                        @if(!$loop->last)
                            <br>
                        @endif
                    @endforeach
                </P>
            @endforeach
        </div>
    </div>
</x-iframe-layout>
