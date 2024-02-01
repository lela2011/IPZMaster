<x-layout>
    <div class="ContentArea">
        <x-flash-message />
        <div class="TextImage" style="display: flex; justify-content: space-between; flex-wrap: wrap;">
            <a href="{{ route('printer.index') }}" class="Button color-border-white size-large" style="margin-bottom: 8px">
                <i class="fa fa-arrow-left" style="margin-right: 8px; vertical-align: bottom"></i>
                Return to List
            </a>
            <a href="{{ route('printer.edit', $printer->id) }}" class="Button color-border-white size-large" style="margin-bottom: 8px">
                Edit Printer
                <i class="fa fa-arrow-right" style="margin-left: 8px; vertical-align: bottom"></i>
            </a>
        </div>
        <div class="TextImage">
            <h2 class="TextImage--title richtext">
                {{ $printer->model ?? "Unknown Printer" }}
            </h2>
            <div class="TextImage--inner">
                <div class="TextImage--text richtext">
                    <h4>
                        Manufacturer:
                    </h4>
                    <p>
                        {{ $printer->manufacturer->name ?? "-" }}
                    </p>
                    <h4>
                        Model:
                    </h4>
                    <p>
                        {{ $printer->model ?? "-" }}
                    </p>
                    <h4>
                        Serial Number:
                    </h4>
                    <p>
                        {{ $printer->serial_number ?? "-" }}
                    </p>
                    <h4>
                        Product Number:
                    </h4>
                    <p>
                        {{ $printer->product_number ?? "-" }}
                    </p>
                    <h4>
                        Location:
                    </h4>
                    <p>
                        {{ $printer->location->name ?? "-" }}
                    </p>
                    <h4>
                        Purchase Date:
                    </h4>
                    <p>
                        {{ $printer->purchase_date ?? "-" }}
                    </p>
                    <h4>
                        Expiration of Warranty:
                    </h4>
                    <p>
                        {{ $printer->warranty_date ?? "-" }}
                    </p>
                    <h4>
                        Notes:
                    </h4>
                    <p>
                        {!! $printer->notes ? nl2br(e($printer->notes)) : "-" !!}
                    </p>
                    <h4>
                        Invoice:
                    </h4>
                    @if ($printer->invoice)
                        <a href="{{ route('admin.inventory.invoice.download', $printer->invoice) }}" target="_blank">View Invoice</a>
                    @else
                        <p>-</p>
                    @endif
                    <h4>
                        Supplier:
                    </h4>
                    <p>
                        {{ $printer->supplier->name ?? "-" }}
                    </p>
                    <h4>
                        Person:
                    </h4>
                    <p>
                        {{ $printer->person->first_name ?? "-" }} {{ $printer->person->last_name ?? "" }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-layout>
