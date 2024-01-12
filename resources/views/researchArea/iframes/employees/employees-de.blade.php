<x-iframe-layout>
    <h2 class="TextImage--title  richtext">Mitarbeiter</h2>
    <div class="TextImage--inner">
        <div class="TextImage--content richtext">
            @foreach ($employeesByType as $typeId => $employees)
                @php
                    $type = $types->firstWhere('id', $typeId);
                @endphp
                <p>
                    <strong>{{ $type->german }}</strong>
                    <br>
                    @foreach ($employees as $employee)
                        <a href="{{ $type->url_german  . ($type->has_personal_page ? $employee->uid : '') }}" target="_blank">{{ $employee->first_name }} {{ $employee->last_name }}</a>
                        @if(!$loop->last)
                            <br>
                        @endif
                    @endforeach
                </p>
            @endforeach
        </div>
    </div>
</x-iframe-layout>
