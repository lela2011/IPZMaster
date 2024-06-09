<x-layout>
    <div class="ContentArea">
        <x-flash-message />
        <div class="TextImage" style="display: flex; justify-content: space-between; flex-wrap: wrap;">
            <a href="{{ route('software.index') }}" class="Button color-border-white size-large" style="margin-bottom: 8px">
                <span class="material-icons" style="margin-right: 8px">arrow_back</span>
                Return to List
            </a>
            <a href="{{ route('software.edit', $software->id) }}" class="Button color-border-white size-large" style="margin-bottom: 8px">
                Edit Software
                <span class="material-icons" style="margin-left: 8px">arrow_forward</span>
            </a>
        </div>
        <div class="TextImage">
            <h2 class="TextImage--title richtext">
                {{ $software->model ?? "Unknown Software" }}
            </h2>
            <div class="TextImage--inner">
                <div class="TextImage--text richtext">
                    <h4>
                        Manufacturer:
                    </h4>
                    <p>
                        {{ $software->manufacturer->name ?? "-" }}
                    </p>
                    <h4>
                        Name:
                    </h4>
                    <p>
                        {{ $software->name ?? "-" }}
                    </p>
                    <h4>
                        License Type:
                    </h4>
                    <p>
                        {{ $software->license_type ?? "-" }}
                    </p>
                    <h4>
                        Purchase Date:
                    </h4>
                    <p>
                        {{ $software->purchase_date ?? "-" }}
                    </p>
                    <h4>
                        Notes:
                    </h4>
                    <p>
                        {!! $software->notes ? nl2br(e($software->notes)) : "-" !!}
                    </p>
                    <h4>
                        Invoice:
                    </h4>
                    @if ($software->invoice)
                        <a href="{{ route('admin.inventory.invoice.download', $software->invoice) }}" target="_blank">View Invoice</a>
                    @else
                        <p>-</p>
                    @endif
                    <h4>
                        Supplier:
                    </h4>
                    <p>
                        {{ $software->supplier->name ?? "-" }}
                    </p>
                    <h4>
                        Quantity:
                    </h4>
                    <p>
                        {{ $software->people->count() }} / {{ $software->quantity }}
                    </p>
                    <h4>
                        People:
                    </h4>
                    <p>
                        <ul>
                            @foreach ($software->people as $person)
                                <li>
                                    {{ $person->first_name }} {{ $person->last_name }}
                                </li>
                            @endforeach
                        </ul>
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-layout>
