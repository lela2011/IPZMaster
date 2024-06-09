<x-layout>
    <div class="ContentArea">
        <x-flash-message />
        <div class="TextImage" style="display: flex; justify-content: space-between; flex-wrap: wrap;">
            <a href="{{ route('monitor.index') }}" class="Button color-border-white size-large" style="margin-bottom: 8px">
                <span class="material-icons" style="margin-right: 8px">arrow_back</span>
                Return to List
            </a>
            <a href="{{ route('monitor.edit', $monitor->id) }}" class="Button color-border-white size-large" style="margin-bottom: 8px">
                Edit Monitor
                <span class="material-icons" style="margin-left: 8px">arrow_forward</span>
            </a>
        </div>
        <div class="TextImage">
            <h2 class="TextImage--title richtext">
                {{ $monitor->model ?? "Unknown Monitor" }}
            </h2>
            <div class="TextImage--inner">
                <div class="TextImage--text richtext">
                    <h4>
                        Manufacturer:
                    </h4>
                    <p>
                        {{ $monitor->manufacturer->name ?? "-" }}
                    </p>
                    <h4>
                        Model:
                    </h4>
                    <p>
                        {{ $monitor->model ?? "-" }}
                    </p>
                    <h4>
                        Size:
                    </h4>
                    <p>
                        {{ $monitor->size ?? "-" }}
                    </p>
                    <h4>
                        Serial Number:
                    </h4>
                    <p>
                        {{ $monitor->serial_number ?? "-" }}
                    </p>
                    <h4>
                        Product Number:
                    </h4>
                    <p>
                        {{ $monitor->product_number ?? "-" }}
                    </p>
                    <h4>
                        Location:
                    </h4>
                    <p>
                        {{ $monitor->location->name ?? "-" }}
                    </p>
                    <h4>
                        Purchase Date:
                    </h4>
                    <p>
                        {{ $monitor->purchase_date ?? "-" }}
                    </p>
                    <h4>
                        Expiration of Warranty:
                    </h4>
                    <p>
                        {{ $monitor->warranty_date ?? "-" }}
                    </p>
                    <h4>
                        Notes:
                    </h4>
                    <p>
                        {!! $monitor->notes ? nl2br(e($monitor->notes)) : "-" !!}
                    </p>
                    <h4>
                        Invoice:
                    </h4>
                    @if ($monitor->invoice)
                        <a href="{{ route('admin.inventory.invoice.download', $monitor->invoice) }}" target="_blank">View Invoice</a>
                    @else
                        <p>-</p>
                    @endif
                    <h4>
                        Supplier:
                    </h4>
                    <p>
                        {{ $monitor->supplier->name ?? "-" }}
                    </p>
                    <h4>
                        Person:
                    </h4>
                    <p>
                        {{ $monitor->person->first_name ?? "-" }} {{ $monitor->person->last_name ?? "" }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-layout>
