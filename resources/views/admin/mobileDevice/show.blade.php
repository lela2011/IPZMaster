<x-layout>
    <div class="ContentArea">
        <x-flash-message />
        <div class="TextImage" style="display: flex; justify-content: space-between; flex-wrap: wrap;">
            <a href="{{ route('mobile-device.index') }}" class="Button color-border-white size-large" style="margin-bottom: 8px">
                <span class="material-icons" style="margin-right: 8px">arrow_back</span>
                Return to List
            </a>
            <a href="{{ route('mobile-device.edit', $mobileDevice->id) }}" class="Button color-border-white size-large" style="margin-bottom: 8px">
                Edit Mobile Device
                <span class="material-icons" style="margin-left: 8px">arrow_forward</span>
            </a>
        </div>
        <div class="TextImage">
            <h2 class="TextImage--title richtext">
                {{ $mobileDevice->model ?? "Unknown Mobile Device" }}
            </h2>
            <div class="TextImage--inner">
                <div class="TextImage--text richtext">
                    <h4>
                        Type:
                    </h4>
                    <p>
                        {{ $mobileDevice->type->name ?? "-" }}
                    </p>
                    <h4>
                        Manufacturer:
                    </h4>
                    <p>
                        {{ $mobileDevice->manufacturer->name ?? "-" }}
                    </p>
                    <h4>
                        Model:
                    </h4>
                    <p>
                        {{ $mobileDevice->model ?? "-" }}
                    </p>
                    <h4>
                        Serial Number:
                    </h4>
                    <p>
                        {{ $mobileDevice->serial_number ?? "-" }}
                    </p>
                    <h4>
                        Product Number:
                    </h4>
                    <p>
                        {{ $mobileDevice->product_number ?? "-" }}
                    </p>
                    <h4>
                        Network Name:
                    </h4>
                    <p>
                        {{ $mobileDevice->network_name ?? "-"}}
                    </p>
                    <h4>
                        IMEI:
                    </h4>
                    <p>
                        {{ $mobileDevice->imei ?? "-"}}
                    </p>
                    <h4>
                        Operating System:
                    </h4>
                    <p>
                        {{ $mobileDevice->operatingSystem->name ?? "-"}}
                    </p>
                    <h4>
                        Storage:
                    </h4>
                    <p>
                        {{ $mobileDevice->storage ?? "-"}}
                    </p>
                    <h4>
                        Color:
                    </h4>
                    <p>
                        {{ $mobileDevice->color ?? "-" }}
                    </p>
                    <h4>
                        Location:
                    </h4>
                    <p>
                        {{ $mobileDevice->location->name ?? "-" }}
                    </p>
                    <h4>
                        Purchase Date:
                    </h4>
                    <p>
                        {{ $mobileDevice->purchase_date ?? "-" }}
                    </p>
                    <h4>
                        Expiration of Warranty:
                    </h4>
                    <p>
                        {{ $mobileDevice->warranty_date ?? "-" }}
                    </p>
                    <h4>
                        Notes:
                    </h4>
                    <p>
                        {!! $mobileDevice->notes ? nl2br(e($mobileDevice->notes)) : "-" !!}
                    </p>
                    <h4>
                        Invoice:
                    </h4>
                    @if ($mobileDevice->invoice)
                        <a href="{{ route('admin.inventory.invoice.download', $mobileDevice->invoice) }}" target="_blank">View Invoice</a>
                    @else
                        <p>-</p>
                    @endif
                    <h4>
                        Supplier:
                    </h4>
                    <p>
                        {{ $mobileDevice->supplier->name ?? "-" }}
                    </p>
                    <h4>
                        Person:
                    </h4>
                    <p>
                        {{ $mobileDevice->person->first_name ?? "-" }} {{ $mobileDevice->person->last_name ?? "" }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-layout>
