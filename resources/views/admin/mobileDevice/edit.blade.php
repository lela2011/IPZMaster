<x-layout>
    <div class="ContentArea">
        <x-flash-message />
        <div class="TextImage" style="display: flex; justify-content: space-between; flex-wrap: wrap;">
            <a href="{{ route('mobile-device.index') }}" class="Button color-border-white size-large"
                style="margin-bottom: 8px">
                <span class="material-icons" style="margin-right: 8px">arrow_back</span>
                Return to List
            </a>
        </div>
        <div class="TextImage">
            <h2 class="TextImage--title richtext">
                Update the Mobile Device: {{ $mobileDevice->model ?? 'Unknown Model' }}
            </h2>
        </div>
        <form class="js-Form Form" action="{{ route('mobile-device.update', $mobileDevice->id) }}" enctype="multipart/form-data" method="POST">
            @csrf
            @method('PUT')
            <div class="Form--body">
                <div class="FormInput">
                    <label class="FormLabel" for="type_id">Type</label>
                    <select class="selectFilter" name="type_id" id="type_id">
                        <option value=""></option>
                        @foreach ($types as $type)
                            <option value="{{ $type->id }}" @if($type->id == old('type_id', $mobileDevice->type_id)) selected @endif>{{ $type->name }}</option>
                        @endforeach
                    </select>
                    @error('type_id')
                    <p class="has-error" style="color: red">
                        {{$message}}
                    </p>
                    @enderror
                </div>
                <div class="FormInput">
                    <label class="FormLabel" for="manufacturer_id">Manufacturer</label>
                    <select class="selectFilter" name="manufacturer_id" id="manufacturer_id">
                        <option value=""></option>
                        @foreach ($manufacturers as $manufacturer)
                            <option value="{{ $manufacturer->id }}" @if($manufacturer->id == old('manufacturer_id', $mobileDevice->manufacturer_id)) selected @endif>{{ $manufacturer->name }}</option>
                        @endforeach
                    </select>
                    @error('manufacturer_id')
                    <p class="has-error" style="color: red">
                        {{$message}}
                    </p>
                    @enderror
                </div>
                <div class="FormInput">
                    <label class="FormLabel" for="model">Model</label>
                    <input class="Input" type="text" name="model" id="model" value="{{ old('model', $mobileDevice->model) }}">
                    @error('model')
                    <p class="has-error" style="color: red">
                        {{$message}}
                    </p>
                    @enderror
                </div>
                <div class="FormInput">
                    <label class="FormLabel" for="serial_number">Serial Number</label>
                    <input class="Input" type="text" name="serial_number" id="serial_number" value="{{ old('serial_number', $mobileDevice->serial_number) }}">
                    @error('serial_number')
                    <p class="has-error" style="color: red">
                        {{$message}}
                    </p>
                    @enderror
                </div>
                <div class="FormInput">
                    <label class="FormLabel" for="product_number">Product Number</label>
                    <input class="Input" type="text" name="product_number" id="product_number" value="{{ old('product_number', $mobileDevice->product_number) }}">
                    @error('product_number')
                    <p class="has-error" style="color: red">
                        {{$message}}
                    </p>
                    @enderror
                </div>
                <div class="FormInput">
                    <label class="FormLabel" for="network_name">Network Name</label>
                    <input class="Input" type="text" name="network_name" id="network_name" value="{{ old('network_name', $mobileDevice->network_name) }}">
                    @error('network_name')
                    <p class="has-error" style="color: red">
                        {{$message}}
                    </p>
                    @enderror
                </div>
                <div class="FormInput">
                    <label class="FormLabel" for="imei">IMEI</label>
                    <input class="Input" type="text" name="imei" id="imei" value="{{ old('imei', $mobileDevice->imei) }}">
                    @error('imei')
                    <p class="has-error" style="color: red">
                        {{$message}}
                    </p>
                    @enderror
                </div>
                <div class="FormInput">
                    <label class="FormLabel" for="operating_system_id">Operating System</label>
                    <select class="selectFilter" name="operating_system_id" id="operating_system_id">
                        <option value=""></option>
                        @foreach ($operatingSystems as $operatingSystem)
                            <option value="{{ $operatingSystem->id }}" @if($operatingSystem->id == old('operating_system_id', $mobileDevice->operating_system_id)) selected @endif>{{ $operatingSystem->name }}</option>
                        @endforeach
                    </select>
                    @error('operating_system_id')
                    <p class="has-error" style="color: red">
                        {{$message}}
                    </p>
                    @enderror
                </div>
                <div class="FormInput">
                    <label class="FormLabel" for="storage">Storage</label>
                    <input class="Input" type="text" name="storage" id="storage" value="{{ old('storage', $mobileDevice->storage) }}">
                    @error('storage')
                    <p class="has-error" style="color: red">
                        {{$message}}
                    </p>
                    @enderror
                </div>
                <div class="FormInput">
                    <label class="FormLabel" for="color">Colour</label>
                    <input class="Input" type="text" name="color" id="color" value="{{ old('color', $mobileDevice->color) }}">
                    @error('color')
                    <p class="has-error" style="color: red">
                        {{$message}}
                    </p>
                    @enderror
                </div>
                <div class="FormInput">
                    <label class="FormLabel" for="location_id">Location</label>
                    <select class="selectFilter" name="location_id" id="location_id">
                        <option value=""></option>
                        @foreach ($locations as $location)
                            <option value="{{ $location->id }}" @if($location->id == old('location_id', $mobileDevice->location_id)) selected @endif>{{ $location->name }}</option>
                        @endforeach
                    </select>
                    @error('location_id')
                    <p class="has-error" style="color: red">
                        {{$message}}
                    </p>
                    @enderror
                </div>
                <div class="FormInput">
                    <label class="FormLabel" for="purchase_date">Purchase Date</label>
                    <input class="Input" type="date" name="purchase_date" id="purchase_date" value="{{ old('purchase_date', $mobileDevice->purchase_date) }}">
                    @error('purchase_date')
                    <p class="has-error" style="color: red">
                        {{$message}}
                    </p>
                    @enderror
                </div>
                <div class="FormInput">
                    <label class="FormLabel" for="warranty_date">Warranty Expiration</label>
                    <input class="Input" type="date" name="warranty_date" id="warranty_date" value="{{ old('warranty_date', $mobileDevice->warranty_date) }}">
                    @error('warranty_date')
                    <p class="has-error" style="color: red">
                        {{$message}}
                    </p>
                    @enderror
                </div>
                <div class="FormInput">
                    <label class="FormLabel" for="notes">Notes</label>
                    <textarea class="Input" type="text" name="notes" id="notes">{!! e(old('notes', $mobileDevice->notes)) !!}</textarea>
                    @error('notes')
                    <p class="has-error" style="color: red">
                        {{$message}}
                    </p>
                    @enderror
                </div>
                <div class="FormInput">
                    <label class="FormLabel" for="invoice">Invoice</label>
                    @if ($mobileDevice->invoice)
                        <div id="current_invoice" style="display: flex; justify-items: center; align-items: center; font-size: 0.875rem; line-height: 1.5; font-weight: 400; color: #666666; margin-bottom: 8pt">
                            <a href="{{ route('admin.inventory.invoice.download', $mobileDevice->invoice) }}" target="_blank" style="display: flex; align-items: center; margin-right: 8pt">
                                <span class="material-icons" style="margin-right: 4pt">
                                    open_in_new
                                </span>
                                <span>
                                    {{ basename($mobileDevice->invoice) }}
                                </span>
                            </a>
                            <button type="button" style="display: flex; align-items: center;" title="Press to remove file">
                               <span class="material-icons">
                                    delete
                               </span>
                            </button>
                        </div>
                    @endif
                    <input id="remove_invoice_input" type="hidden" name="remove_invoice_input" value="0">
                    <input class="File--input" type="file" accept=".pdf,.doc,.docx" name="invoice" id="invoice">
                    @error('invoice')
                        <p class="has-error" style="color: red">
                            {{$message}}
                        </p>
                    @enderror
                </div>
                <div class="FormInput">
                    <label class="FormLabel" for="supplier_id">Supplier</label>
                    <select class="selectFilter" name="supplier_id" id="supplier_id">
                        <option value=""></option>
                        @foreach ($suppliers as $supplier)
                            <option value="{{ $supplier->id }}" @if($supplier->id == old('supplier_id', $mobileDevice->supplier_id)) selected @endif>{{ $supplier->name }}</option>
                        @endforeach
                    </select>
                    @error('supplier_id')
                    <p class="has-error" style="color: red">
                        {{$message}}
                    </p>
                    @enderror
                </div>
                <div class="FormInput">
                    <label class="FormLabel" for="user_id">Person</label>
                    <select class="selectFilter" name="user_id" id="user_id">
                        <option value=""></option>
                        @foreach ($people as $person)
                            <option value="{{ $person->uid }}" @if($person->uid == old('user_id', $mobileDevice->user_id)) selected @endif>{{ $person->first_name }} {{ $person->last_name }}</option>
                        @endforeach
                    </select>
                    @error('user_id')
                    <p class="has-error" style="color: red">
                        {{$message}}
                    </p>
                    @enderror
                </div>
                <div class="FormButtons">
                    <a href="{{route('mobile-device.index')}}" class="Button color-border-white size-large">
                        <span class="Button--inner">
                            Cancel
                        </span>
                    </a>
                    <button class="Button color-primary size-large" type="submit">
                        <span class="Button--inner">Update</span>
                    </button>
                </div>
            </div>
        </form>
    </div>
</x-layout>
<script>
    $(document).ready(function() {

        $("#current_invoice button").on("click", function () {
            // Find the closest parent div and remove it
            $(this).closest("#current_invoice").remove();
            // set the remove_invoice_input to true
            $('#remove_invoice_input').val(1);
        });

        // Initialize selecctize
        $('.selectFilter').selectize({
            create: false,
            sortField: 'text'
        });
    });
</script>
