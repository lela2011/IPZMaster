<x-layout>
    <div class="ContentArea">
        <x-flash-message />
        <div class="TextImage" style="display: flex; justify-content: space-between; flex-wrap: wrap;">
            <a href="{{ route('software.index') }}" class="Button color-border-white size-large"
                style="margin-bottom: 8px">
                <span class="material-icons" style="margin-right: 8px">arrow_back</span>
                Return to List
            </a>
        </div>
        <div class="TextImage">
            <h2 class="TextImage--title richtext">
                Copy and Modify the Software
            </h2>
        </div>
        <form class="js-Form Form" action="{{ route('software.store') }}" enctype="multipart/form-data" method="POST">
            @csrf
            <div class="Form--body">
                <div class="FormInput">
                    <label class="FormLabel" for="manufacturer_id">Manufacturer</label>
                    <select class="selectFilter" name="manufacturer_id" id="manufacturer_id">
                        <option value=""></option>
                        @foreach ($manufacturers as $manufacturer)
                            <option value="{{ $manufacturer->id }}" @if($manufacturer->id == old('manufacturer_id', $software->manufacturer_id)) selected @endif>{{ $manufacturer->name }}</option>
                        @endforeach
                    </select>
                    @error('manufacturer_id')
                    <p class="has-error" style="color: red">
                        {{$message}}
                    </p>
                    @enderror
                </div>
                <div class="FormInput">
                    <label class="FormLabel" for="name">Name</label>
                    <input class="Input" type="text" name="name" id="name" value="{{ old('name', $software->name) }}">
                    @error('name')
                    <p class="has-error" style="color: red">
                        {{$message}}
                    </p>
                    @enderror
                </div>
                <div class="FormInput">
                    <label class="FormLabel" for="license_type">License Type</label>
                    <input class="Input" type="text" name="license_type" id="license_type" value="{{ old('license_type', $software->license_type) }}">
                    @error('license_type')
                    <p class="has-error" style="color: red">
                        {{$message}}
                    </p>
                    @enderror
                </div>
                <div class="FormInput">
                    <label class="FormLabel" for="purchase_date">Purchase Date</label>
                    <input class="Input" type="date" name="purchase_date" id="purchase_date" value="{{ old('purchase_date', $software->purchase_date) }}">
                    @error('purchase_date')
                    <p class="has-error" style="color: red">
                        {{$message}}
                    </p>
                    @enderror
                </div>
                <div class="FormInput">
                    <label class="FormLabel" for="notes">Notes</label>
                    <textarea class="Input" type="text" name="notes" id="notes">{!! e(old('notes', $software->notes)) !!}</textarea>
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
                            <option value="{{ $supplier->id }}" @if($supplier->id == old('supplier_id', $software->supplier_id)) selected @endif>{{ $supplier->name }}</option>
                        @endforeach
                    </select>
                    @error('supplier_id')
                    <p class="has-error" style="color: red">
                        {{$message}}
                    </p>
                    @enderror
                </div>
                <div class="FormInput">
                    <label class="FormLabel" for="quantity">Quantity</label>
                    <input class="Input" type="number" name="quantity" id="quantity" value="{{ old('quantity', $software->quantity) }}">
                    @error('quantity')
                    <p class="has-error" style="color: red">
                        {{$message}}
                    </p>
                    @enderror
                </div>
                <div class="FormInput">
                    <label class="FormLabel" for="people">People</label>
                    <select class="selectFilter" type="text" name="people[]" id="people" multiple>
                        @foreach ($people as $person)
                            <option value="{{ $person->uid }}" @if(collect(old('people', $software->people))->contains($person->uid)) selected @endif>{{ $person->first_name }} {{ $person->last_name }}</option>
                        @endforeach
                    </select>
                    @error('people')
                    <p class="has-error" style="color: red">
                        {{$message}}
                    </p>
                    @enderror
                </div>
                <div class="FormButtons">
                    <a href="{{route('software.index')}}" class="Button color-border-white size-large">
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
