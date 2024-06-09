<x-layout>
    <div class="ContentArea">
        <x-flash-message />
        <div class="TextImage" style="display: flex; justify-content: space-between; flex-wrap: wrap;">
            <a href="{{ route('computer.index') }}" class="Button color-border-white size-large" style="margin-bottom: 8px">
                <span class="material-icons" style="margin-right: 8px">arrow_back</span>
                Return to List
            </a>
            <a href="{{ route('computer.edit', $computer->id) }}" class="Button color-border-white size-large" style="margin-bottom: 8px">
                Edit Computer
                <span class="material-icons" style="margin-left: 8px">arrow_forward</span>
            </a>
        </div>
        <div class="TextImage">
            <h2 class="TextImage--title richtext">
                {{ $computer->model ?? "Unknown Computer" }}
            </h2>
            <div class="TextImage--inner">
                <div class="TextImage--text richtext">
                    <h4>
                        Type:
                    </h4>
                    <p>
                        {{ $computer->type->name ?? "-" }}
                    </p>
                    <h4>
                        Manufacturer:
                    </h4>
                    <p>
                        {{ $computer->manufacturer->name ?? "-" }}
                    </p>
                    <h4>
                        Model:
                    </h4>
                    <p>
                        {{ $computer->model ?? "-" }}
                    </p>
                    <h4>
                        Serial Number:
                    </h4>
                    <p>
                        {{ $computer->serial_number ?? "-" }}
                    </p>
                    <h4>
                        Product Number:
                    </h4>
                    <p>
                        {{ $computer->product_number ?? "-" }}
                    </p>
                    <h4>
                        Mac Address:
                    </h4>
                    <p>
                        {{ $computer->mac_address ?? "-"}}
                    </p>
                    <h4>
                        Network Name:
                    </h4>
                    <p>
                        {{ $computer->network_name ?? "-"}}
                    </p>
                    <h4>
                        Operating System:
                    </h4>
                    <p>
                        {{ $computer->operatingSystem->name ?? "-"}}
                    </p>
                    <h4>
                        CPU:
                    </h4>
                    <p>
                        {{ $computer->cpu ?? "-"}}
                    </p>
                    <h4>
                        RAM:
                    </h4>
                    <p>
                        {{ $computer->ram ?? "-" }}
                    </p>
                    <h4>
                        Storage:
                    </h4>
                    <p>
                        {{ $computer->storage ?? "-"}}
                    </p>
                    <h4>
                        Color:
                    </h4>
                    <p>
                        {{ $computer->color ?? "-" }}
                    </p>
                    <h4>
                        Keyboard Layout:
                    </h4>
                    <p>
                        {{ $computer->keyboardLayout->name ?? "-" }}
                    </p>
                    <h4>
                        Location:
                    </h4>
                    <p>
                        {{ $computer->location->name ?? "-" }}
                    </p>
                    <h4>
                        Purchase Date:
                    </h4>
                    <p>
                        {{ $computer->purchase_date ?? "-" }}
                    </p>
                    <h4>
                        Expiration of Warranty:
                    </h4>
                    <p>
                        {{ $computer->warranty_date ?? "-" }}
                    </p>
                    <h4>
                        Notes:
                    </h4>
                    <p>
                        {!! $computer->notes ? nl2br(e($computer->notes)) : "-" !!}
                    </p>
                    <h4>
                        Invoice:
                    </h4>
                    @if ($computer->invoice)
                        <a href="{{ route('admin.inventory.invoice.download', $computer->invoice) }}" target="_blank">View Invoice</a>
                    @else
                        <p>-</p>
                    @endif
                    <h4>
                        Supplier:
                    </h4>
                    <p>
                        {{ $computer->supplier->name ?? "-" }}
                    </p>
                    <h4>
                        Person:
                    </h4>
                    <p>
                        {{ $computer->person->first_name ?? "-" }} {{ $computer->person->last_name ?? "" }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-layout>
