<x-layout>
    <div class="ContentArea">
        <x-flash-message />
        <div class="TextImage" style="display: flex; justify-content: space-between; flex-wrap: wrap;">
            <a href="{{ route('peripheral.index') }}" class="Button color-border-white size-large" style="margin-bottom: 8px">
                <i class="fa fa-arrow-left" style="margin-right: 8px; vertical-align: bottom"></i>
                Return to List
            </a>
            <a href="{{ route('peripheral.edit', $peripheral->id) }}" class="Button color-border-white size-large" style="margin-bottom: 8px">
                Edit Peripheral
                <i class="fa fa-arrow-right" style="margin-left: 8px; vertical-align: bottom"></i>
            </a>
        </div>
        <div class="TextImage">
            <h2 class="TextImage--title richtext">
                {{ $peripheral->model ?? "Unknown Peripheral" }}
            </h2>
            <div class="TextImage--inner">
                <div class="TextImage--text richtext">
                    <h4>
                        Type:
                    </h4>
                    <p>
                        {{ $peripheral->type->name ?? "-" }}
                    </p>
                    <h4>
                        Manufacturer:
                    </h4>
                    <p>
                        {{ $peripheral->manufacturer->name ?? "-" }}
                    </p>
                    <h4>
                        Model:
                    </h4>
                    <p>
                        {{ $peripheral->model ?? "-" }}
                    </p>
                    <h4>
                        Serial Number:
                    </h4>
                    <p>
                        {{ $peripheral->serial_number ?? "-" }}
                    </p>
                    <h4>
                        Product Number:
                    </h4>
                    <p>
                        {{ $peripheral->product_number ?? "-" }}
                    </p>
                    <h4>
                        Location:
                    </h4>
                    <p>
                        {{ $peripheral->location->name ?? "-" }}
                    </p>
                    <h4>
                        Purchase Date:
                    </h4>
                    <p>
                        {{ $peripheral->purchase_date ?? "-" }}
                    </p>
                    <h4>
                        Expiration of Warranty:
                    </h4>
                    <p>
                        {{ $peripheral->warranty_date ?? "-" }}
                    </p>
                    <h4>
                        Notes:
                    </h4>
                    <p>
                        {!! $peripheral->notes ? nl2br(e($peripheral->notes)) : "-" !!}
                    </p>
                    <h4>
                        Invoice:
                    </h4>
                    @if ($peripheral->invoice)
                        <a href="{{ route('admin.inventory.invoice.download', $peripheral->invoice) }}" target="_blank">View Invoice</a>
                    @else
                        <p>-</p>
                    @endif
                    <h4>
                        Supplier:
                    </h4>
                    <p>
                        {{ $peripheral->supplier->name ?? "-" }}
                    </p>
                    <h4>
                        Person:
                    </h4>
                    <p>
                        {{ $peripheral->person->first_name ?? "-" }} {{ $peripheral->person->last_name ?? "" }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-layout>
