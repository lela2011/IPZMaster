<x-layout>
    <div class="ContentArea">
        <x-flash-message />
        <div class="TextImage" style="display: flex; justify-content: space-between; flex-wrap: wrap;">
            <a href="{{ route('computer.index') }}" class="Button color-border-white size-large"
                style="margin-bottom: 8px">
                <i class="fa fa-arrow-left" style="margin-right: 8px; vertical-align: bottom"></i>
                Return to List
            </a>
        </div>
        <div class="TextImage">
            <h2 class="TextImage--title richtext">
                Update the Computer: {{ $computer->model ?? 'Unknown Model' }}
            </h2>
        </div>
        <form class="js-Form Form" action="{{ route('computer.update', $computer->id) }}" enctype="multipart/form-data" method="POST">
            @csrf
            @method('PUT')
            <div class="Form--body">
                <div class="FormInput">
                    <label class="FormLabel" for="type_id">Type</label>
                    <select class="selectFilter" name="type_id" id="type_id">
                        <option value=""></option>
                        @foreach ($types as $type)
                            <option value="{{ $type->id }}" @if($type->id == old('type_id', $computer->type_id)) selected @endif>{{ $type->name }}</option>
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
                            <option value="{{ $manufacturer->id }}" @if($manufacturer->id == old('manufacturer_id', $computer->manufacturer_id)) selected @endif>{{ $manufacturer->name }}</option>
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
                    <input class="Input" type="text" name="model" id="model" value="{{ old('model', $computer->model) }}">
                    @error('model')
                    <p class="has-error" style="color: red">
                        {{$message}}
                    </p>
                    @enderror
                </div>
                <div class="FormInput">
                    <label class="FormLabel" for="serial_number">Serial Number</label>
                    <input class="Input" type="text" name="serial_number" id="serial_number" value="{{ old('serial_number', $computer->serial_number) }}">
                    @error('serial_number')
                    <p class="has-error" style="color: red">
                        {{$message}}
                    </p>
                    @enderror
                </div>
                <div class="FormInput">
                    <label class="FormLabel" for="product_number">Product Number</label>
                    <input class="Input" type="text" name="product_number" id="product_number" value="{{ old('product_number', $computer->product_number) }}">
                    @error('product_number')
                    <p class="has-error" style="color: red">
                        {{$message}}
                    </p>
                    @enderror
                </div>
                <div class="FormInput">
                    <label class="FormLabel" for="mac_address">MAC Address</label>
                    <input class="Input" type="text" name="mac_address" id="mac_address" value="{{ old('mac_address', $computer->mac_address) }}">
                    @error('mac_address')
                    <p class="has-error" style="color: red">
                        {{$message}}
                    </p>
                    @enderror
                </div>
                <div class="FormInput">
                    <label class="FormLabel" for="network_name">Network Name</label>
                    <input class="Input" type="text" name="network_name" id="network_name" value="{{ old('network_name', $computer->network_name) }}">
                    @error('network_name')
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
                            <option value="{{ $operatingSystem->id }}" @if($operatingSystem->id == old('operating_system_id', $computer->operating_system_id)) selected @endif>{{ $operatingSystem->name }}</option>
                        @endforeach
                    </select>
                    @error('operating_system_id')
                    <p class="has-error" style="color: red">
                        {{$message}}
                    </p>
                    @enderror
                </div>
                <div class="FormInput">
                    <label class="FormLabel" for="cpu">CPU</label>
                    <input class="Input" type="text" name="cpu" id="cpu" value="{{ old('cpu', $computer->cpu) }}">
                    @error('cpu')
                    <p class="has-error" style="color: red">
                        {{$message}}
                    </p>
                    @enderror
                </div>
                <div class="FormInput">
                    <label class="FormLabel" for="ram">RAM</label>
                    <input class="Input" type="text" name="ram" id="ram" value="{{ old('ram', $computer->ram) }}">
                    @error('ram')
                    <p class="has-error" style="color: red">
                        {{$message}}
                    </p>
                    @enderror
                </div>
                <div class="FormInput">
                    <label class="FormLabel" for="storage">Storage</label>
                    <input class="Input" type="text" name="storage" id="storage" value="{{ old('storage', $computer->storage) }}">
                    @error('storage')
                    <p class="has-error" style="color: red">
                        {{$message}}
                    </p>
                    @enderror
                </div>
                <div class="FormInput">
                    <label class="FormLabel" for="color">Colour</label>
                    <input class="Input" type="text" name="color" id="color" value="{{ old('color', $computer->color) }}">
                    @error('color')
                    <p class="has-error" style="color: red">
                        {{$message}}
                    </p>
                    @enderror
                </div>
                <div class="FormInput">
                    <label class="FormLabel" for="keyboard_layout_id">Keyboard Layout</label>
                    <select class="selectFilter" name="keyboard_layout_id" id="keyboard_layout_id">
                        <option value=""></option>
                        @foreach ($keyboardLayouts as $keyboardLayout)
                            <option value="{{ $keyboardLayout->id }}" @if($keyboardLayout->id == old('keyboard_layout_id', $computer->keyboard_layout_id)) selected @endif>{{ $keyboardLayout->name }}</option>
                        @endforeach
                    </select>
                    @error('keyboard_layout_id')
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
                            <option value="{{ $location->id }}" @if($location->id == old('location_id', $computer->location_id)) selected @endif>{{ $location->name }}</option>
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
                    <input class="Input" type="date" name="purchase_date" id="purchase_date" value="{{ old('purchase_date', $computer->purchase_date) }}">
                    @error('purchase_date')
                    <p class="has-error" style="color: red">
                        {{$message}}
                    </p>
                    @enderror
                </div>
                <div class="FormInput">
                    <label class="FormLabel" for="warranty_date">Warranty Expiration</label>
                    <input class="Input" type="date" name="warranty_date" id="warranty_date" value="{{ old('warranty_date', $computer->warranty_date) }}">
                    @error('warranty_date')
                    <p class="has-error" style="color: red">
                        {{$message}}
                    </p>
                    @enderror
                </div>
                <div class="FormInput">
                    <label class="FormLabel" for="notes">Notes</label>
                    <textarea class="Input" type="text" name="notes" id="notes">{!! nl2br(e(old('notes', $computer->notes))) !!}</textarea>
                    @error('notes')
                    <p class="has-error" style="color: red">
                        {{$message}}
                    </p>
                    @enderror
                </div>
                <div class="FormInput">
                    <label class="FormLabel" for="invoice">Invoice</label>
                    @if ($computer->invoice)
                        <a id="current_invoice" href="{{ $computer->invoice() }}" target="_blank" style="align-items: center; margin: 8px 0 16px 0" class="Button color-border-white size-large">
                            <span class="material-icons">
                                description
                            </span>
                            <span style="margin: 0 8px;">Current Invoice</span>
                            <span class="material-icons">
                                download
                            </span>
                        </a>
                        <button type="button" id="remove_invoice" target="_blank" style="align-items: center; margin: 8px 0 16px 8px" class="Button color-border-white size-large">
                            <span class="material-icons">
                                delete
                            </span>
                            <span style="margin: 0 8px;">Remove Invoice</span>
                        </button>
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
                            <option value="{{ $supplier->id }}" @if($supplier->id == old('supplier_id', $computer->supplier_id)) selected @endif>{{ $supplier->name }}</option>
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
                            <option value="{{ $person->uid }}" @if($person->uid == old('user_id', $computer->user_id)) selected @endif>{{ $person->first_name }} {{ $person->last_name }}</option>
                        @endforeach
                    </select>
                    @error('user_id')
                    <p class="has-error" style="color: red">
                        {{$message}}
                    </p>
                    @enderror
                </div>
                <div class="FormButtons">
                    <a href="{{route('computer.index')}}" class="Button color-border-white size-large">
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
        $('#remove_invoice').click(function() {
            $('#remove_invoice_input').val(1);
            $('#current_invoice').hide();
            $('#remove_invoice').hide();
        });

        $('.selectFilter').selectize({
            create: false,
            sortField: 'text'
        });
    });
</script>
