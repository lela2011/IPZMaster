<x-layout>
    <div class="ContentArea">
        <x-flash-message />
        <div class="TextImage" style="display: flex; justify-content: space-between; flex-wrap: wrap;">
            <a href="{{ route('monitor.index') }}" class="Button color-border-white size-large"
                style="margin-bottom: 8px">
                <span class="material-icons" style="margin-right: 8px">arrow_back</span>
                Return to List
            </a>
        </div>
        <div class="TextImage">
            <h2 class="TextImage--title richtext">
                Create a new Monitor
            </h2>
        </div>
        <form class="js-Form Form" action="{{ route('monitor.store') }}" enctype="multipart/form-data" method="POST">
            @csrf
            <div class="Form--body">
                <div class="FormInput">
                    <label class="FormLabel" for="manufacturer_id">Manufacturer</label>
                    <select class="selectFilter" name="manufacturer_id" id="manufacturer_id">
                        <option value=""></option>
                        @foreach ($manufacturers as $manufacturer)
                            <option value="{{ $manufacturer->id }}" @if($manufacturer->id == old('manufacturer_id')) selected @endif>{{ $manufacturer->name }}</option>
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
                    <input class="Input" type="text" name="model" id="model" value="{{ old('model') }}">
                    @error('model')
                    <p class="has-error" style="color: red">
                        {{$message}}
                    </p>
                    @enderror
                </div>
                <div class="FormInput">
                    <label class="FormLabel" for="size">Size</label>
                    <input class="Input" type="text" name="size" id="size" value="{{ old('size') }}">
                    @error('size')
                    <p class="has-error" style="color: red">
                        {{$message}}
                    </p>
                    @enderror
                </div>
                <div class="FormInput">
                    <label class="FormLabel" for="serial_number">Serial Number</label>
                    <input class="Input" type="text" name="serial_number" id="serial_number" value="{{ old('serial_number') }}">
                    @error('serial_number')
                    <p class="has-error" style="color: red">
                        {{$message}}
                    </p>
                    @enderror
                </div>
                <div class="FormInput">
                    <label class="FormLabel" for="product_number">Product Number</label>
                    <input class="Input" type="text" name="product_number" id="product_number" value="{{ old('product_number') }}">
                    @error('product_number')
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
                            <option value="{{ $location->id }}" @if($location->id == old('location_id')) selected @endif>{{ $location->name }}</option>
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
                    <input class="Input" type="date" name="purchase_date" id="purchase_date" value="{{ old('purchase_date') }}">
                    @error('purchase_date')
                    <p class="has-error" style="color: red">
                        {{$message}}
                    </p>
                    @enderror
                </div>
                <div class="FormInput">
                    <label class="FormLabel" for="warranty_date">Warranty Expiration</label>
                    <input class="Input" type="date" name="warranty_date" id="warranty_date" value="{{ old('warranty_date') }}">
                    @error('warranty_date')
                    <p class="has-error" style="color: red">
                        {{$message}}
                    </p>
                    @enderror
                </div>
                <div class="FormInput">
                    <label class="FormLabel" for="notes">Notes</label>
                    <textarea class="Input" type="text" name="notes" id="notes">{!! e(old('notes')) !!}</textarea>
                    @error('notes')
                    <p class="has-error" style="color: red">
                        {{$message}}
                    </p>
                    @enderror
                </div>
                <div class="FormInput">
                    <label class="FormLabel" for="invoice">Invoice</label>
                    <input class="File--input" type="file" accept=".pdf,.doc,.docx,.txt" value="{{ old('invoice') }}" name="invoice" id="invoice">
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
                            <option value="{{ $supplier->id }}" @if($supplier->id == old('supplier_id')) selected @endif>{{ $supplier->name }}</option>
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
                            <option value="{{ $person->uid }}" @if($person->uid == old('user_id')) selected @endif>{{ $person->first_name }} {{ $person->last_name }}</option>
                        @endforeach
                    </select>
                    @error('user_id')
                    <p class="has-error" style="color: red">
                        {{$message}}
                    </p>
                    @enderror
                </div>
                <div class="FormButtons">
                    <a href="{{route('monitor.index')}}" class="Button color-border-white size-large">
                        <span class="Button--inner">
                            Cancel
                        </span>
                    </a>
                    <button class="Button color-primary size-large" type="submit">
                        <span class="Button--inner">Create</span>
                    </button>
                </div>
            </div>
        </form>
    </div>
</x-layout>
<script>
    $('.selectFilter').selectize({
            create: false,
            sortField: 'text'
        });
</script>
