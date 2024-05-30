<x-layout>
    <div class="ContentArea">
        <x-confirm-modal />
        <x-flash-message />
        <div class="TextImage" style="display: flex; justify-content: space-between; flex-wrap: wrap;">
            <a href="{{ route('admin.inventory.dashboard') }}" class="Button color-border-white size-large"
                style="margin-bottom: 8px">
                <i class="fa fa-arrow-left" style="margin-right: 8px; vertical-align: bottom"></i>
                Return to Inventory Dashboard
            </a>
            <a href="{{ route('computer.create') }}" class="Button color-border-white size-large"
                style="margin-bottom: 8px">
                Add new Computer
                <i class="fa fa-arrow-right" style="margin-left: 8px; vertical-align: bottom"></i>
            </a>
        </div>
        <div class="TextImage">
            <h2 class="TextImage--title richtext">
                Computers
            </h2>
        </div>
        <form class="js-Form Form" action="{{ route('computer.index') }}" method="GET">
            <div class="Form--header">
                <h2 id="expandSurface" class="Form--title" style="cursor: pointer">Filter (click to expand)</h2>
            </div>
            <div id="expandable" style="display: none">
                <div class="Form--body">
                    <div class="FormInput">
                        <label class="FormLabel" for="type_id">Type</label>
                        <select class="selectFilter" name="type_id" id="type_id">
                            <option value="">All</option>
                            @foreach ($types as $type)
                                <option value="{{ $type->id }}" @if($type->id == optional($filters)['type_id']) selected @endif>{{ $type->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="FormInput">
                        <label class="FormLabel" for="manufacturer_id">Manufacturer</label>
                        <select class="selectFilter" name="manufacturer_id" id="manufacturer_id">
                            <option value="">All</option>
                            @foreach ($manufacturers as $manufacturer)
                                <option value="{{ $manufacturer->id }}" @if($manufacturer->id == optional($filters)['manufacturer_id']) selected @endif>{{ $manufacturer->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="FormInput">
                        <label class="FormLabel" for="model">Model</label>
                        <input class="Input" type="text" name="model" id="model" value="{{ optional($filters)['model'] }}">
                    </div>
                    <div class="FormInput">
                        <label class="FormLabel" for="serial_number">Serial Number</label>
                        <input class="Input" type="text" name="serial_number" id="serial_number" value="{{ optional($filters)['serial_number'] }}">
                    </div>
                    <div class="FormInput">
                        <label class="FormLabel" for="product_number">Product Number</label>
                        <input class="Input" type="text" name="product_number" id="product_number" value="{{ optional($filters)['product_number'] }}">
                    </div>
                    <div class="FormInput">
                        <label class="FormLabel" for="mac_address">MAC Address</label>
                        <input class="Input" type="text" name="mac_address" id="mac_address" value="{{ optional($filters)['mac_address'] }}">
                    </div>
                    <div class="FormInput">
                        <label class="FormLabel" for="network_name">Network Name</label>
                        <input class="Input" type="text" name="network_name" id="network_name" value="{{ optional($filters)['network_name'] }}">
                    </div>
                    <div class="FormInput">
                        <label class="FormLabel" for="operating_system_id">Operating System</label>
                        <select class="selectFilter" name="operating_system_id" id="operating_system_id">
                            <option value="">All</option>
                            @foreach ($operatingSystems as $operatingSystem)
                                <option value="{{ $operatingSystem->id }}" @if($operatingSystem->id == optional($filters)['operating_system_id']) selected @endif>{{ $operatingSystem->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="FormInput">
                        <label class="FormLabel" for="cpu">CPU</label>
                        <input class="Input" type="text" name="cpu" id="cpu" value="{{ optional($filters)['cpu'] }}">
                    </div>
                    <div class="FormInput">
                        <label class="FormLabel" for="ram">RAM</label>
                        <input class="Input" type="text" name="ram" id="ram" value="{{ optional($filters)['ram'] }}">
                    </div>
                    <div class="FormInput">
                        <label class="FormLabel" for="storage">Storage</label>
                        <input class="Input" type="text" name="storage" id="storage" value="{{ optional($filters)['storage'] }}">
                    </div>
                    <div class="FormInput">
                        <label class="FormLabel" for="color">Colour</label>
                        <input class="Input" type="text" name="color" id="color" value="{{ optional($filters)['color'] }}">
                    </div>
                    <div class="FormInput">
                        <label class="FormLabel" for="keyboard_layout_id">Keyboard Layout</label>
                        <select class="selectFilter" name="keyboard_layout_id" id="keyboard_layout_id">
                            <option value="">All</option>
                            @foreach ($keyboardLayouts as $keyboardLayout)
                                <option value="{{ $keyboardLayout->id }}" @if($keyboardLayout->id == optional($filters)['keyboard_layout_id']) selected @endif>{{ $keyboardLayout->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="FormInput">
                        <label class="FormLabel" for="location_id">Location</label>
                        <select class="selectFilter" name="location_id" id="location_id">
                            <option value="">All</option>
                            @foreach ($locations as $location)
                                <option value="{{ $location->id }}" @if($location->id == optional($filters)['location_id']) selected @endif>{{ $location->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="FormInput">
                        <label class="FormLabel" for="purchase_date">Purchase Date</label>
                        <input class="Input" type="date" name="purchase_date" id="purchase_date" value="{{ optional($filters)['purchase_date'] }}">
                    </div>
                    <div class="FormInput">
                        <label class="FormLabel" for="warranty_date">Warranty Expiration</label>
                        <input class="Input" type="date" name="warranty_date" id="warranty_date" value="{{ optional($filters)['warranty_date'] }}">
                    </div>
                    <div class="FormInput">
                        <label class="FormLabel" for="notes">Notes</label>
                        <input class="Input" type="text" name="notes" id="notes" value="{{ optional($filters)['notes'] }}">
                    </div>
                    <div class="FormInput">
                        <label class="FormLabel" for="supplier_id">Supplier</label>
                        <select class="selectFilter" name="supplier_id" id="supplier_id">
                            <option value="">All</option>
                            @foreach ($suppliers as $supplier)
                                <option value="{{ $supplier->id }}" @if($supplier->id == optional($filters)['supplier_id']) selected @endif>{{ $supplier->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="FormInput">
                        <label class="FormLabel" for="user_id">Person</label>
                        <select class="selectFilter" name="user_id" id="user_id">
                            <option value="">All</option>
                            @foreach ($people as $person)
                                <option value="{{ $person->uid }}" @if($person->uid == optional($filters)['user_id']) selected @endif>{{ $person->first_name }} {{ $person->last_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="FormButtons">
                        <a href="{{route('computer.index')}}" class="Button color-border-white size-large">
                            <span class="Button--inner">
                                Reset Filters
                            </span>
                        </a>
                        <button class="Button color-primary size-large" type="submit">
                            <span class="Button--inner">Filter</span>
                        </button>
                    </div>
                </div>
            </div>
        </form>
        <div class="TextImage">
            <div class="TextImage--content richtext" style="overflow-x: scroll">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col" colspan="4">Actions</th>
                            <th scope="col">
                                <a class="quickaction-anchor sort" href="{{ route('computer.index', array_merge(request()->except(['sort', 'direction']), ['sort' => 'type_id', 'direction' => request('sort') === 'type_id' && request('direction') === 'asc' ? 'desc' : 'asc'])) }}">
                                    Type
                                    @if(request('sort') === 'type_id')
                                        @if(request('direction') === 'asc')
                                            &uarr;
                                        @else
                                            &darr;
                                        @endif
                                    @endif
                                </a>
                            </th>
                            <th scope="col">
                                <a class="quickaction-anchor sort" href="{{ route('computer.index', array_merge(request()->except(['sort', 'direction']), ['sort' => 'manufacturer_id', 'direction' => request('sort') === 'manufacturer_id' && request('direction') === 'asc' ? 'desc' : 'asc'])) }}">
                                    Manufacturer
                                    @if(request('sort') === 'manufacturer_id')
                                        @if(request('direction') === 'asc')
                                            &uarr;
                                        @else
                                            &darr;
                                        @endif
                                    @endif
                                </a>
                            </th>
                            <th scope="col">
                                <a class="quickaction-anchor sort" href="{{ route('computer.index', array_merge(request()->except(['sort', 'direction']), ['sort' => 'model', 'direction' => request('sort') === 'model' && request('direction') === 'asc' ? 'desc' : 'asc'])) }}">
                                    Model
                                    @if(request('sort') === 'model')
                                        @if(request('direction') === 'asc')
                                            &uarr;
                                        @else
                                            &darr;
                                        @endif
                                    @endif
                                </a>
                            </th>
                            <th scope="col">
                                <a class="quickaction-anchor sort" href="{{ route('computer.index', array_merge(request()->except(['sort', 'direction']), ['sort' => 'serial_number', 'direction' => request('sort') === 'serial_number' && request('direction') === 'asc' ? 'desc' : 'asc'])) }}">
                                    Serial Number
                                    @if(request('sort') === 'serial_number')
                                        @if(request('direction') === 'asc')
                                            &uarr;
                                        @else
                                            &darr;
                                        @endif
                                    @endif
                                </a>
                            </th>
                            <th scope="col">
                                <a class="quickaction-anchor sort" href="{{ route('computer.index', array_merge(request()->except(['sort', 'direction']), ['sort' => 'product_number', 'direction' => request('sort') === 'product_number' && request('direction') === 'asc' ? 'desc' : 'asc'])) }}">
                                    Product Number
                                    @if(request('sort') === 'product_number')
                                        @if(request('direction') === 'asc')
                                            &uarr;
                                        @else
                                            &darr;
                                        @endif
                                    @endif
                                </a>
                            </th>
                            <th scope="col">
                                <a class="quickaction-anchor sort" href="{{ route('computer.index', array_merge(request()->except(['sort', 'direction']), ['sort' => 'mac_address', 'direction' => request('sort') === 'mac_address' && request('direction') === 'asc' ? 'desc' : 'asc'])) }}">
                                    MAC Address
                                    @if(request('sort') === 'mac_address')
                                        @if(request('direction') === 'asc')
                                            &uarr;
                                        @else
                                            &darr;
                                        @endif
                                    @endif
                                </a>
                            </th>
                            <th scope="col">
                                <a class="quickaction-anchor sort" href="{{ route('computer.index', array_merge(request()->except(['sort', 'direction']), ['sort' => 'network_name', 'direction' => request('sort') === 'network_name' && request('direction') === 'asc' ? 'desc' : 'asc'])) }}">
                                    Network Name
                                    @if(request('sort') === 'network_name')
                                        @if(request('direction') === 'asc')
                                            &uarr;
                                        @else
                                            &darr;
                                        @endif
                                    @endif
                                </a>
                            </th>
                            <th scope="col">
                                <a class="quickaction-anchor sort" href="{{ route('computer.index', array_merge(request()->except(['sort', 'direction']), ['sort' => 'operating_system_id', 'direction' => request('sort') === 'operating_system_id' && request('direction') === 'asc' ? 'desc' : 'asc'])) }}">
                                    Operating System
                                    @if(request('sort') === 'operating_system_id')
                                        @if(request('direction') === 'asc')
                                            &uarr;
                                        @else
                                            &darr;
                                        @endif
                                    @endif
                                </a>
                            </th>
                            <th scope="col">
                                <a class="quickaction-anchor sort" href="{{ route('computer.index', array_merge(request()->except(['sort', 'direction']), ['sort' => 'cpu', 'direction' => request('sort') === 'cpu' && request('direction') === 'asc' ? 'desc' : 'asc'])) }}">
                                    CPU
                                    @if(request('sort') === 'cpu')
                                        @if(request('direction') === 'asc')
                                            &uarr;
                                        @else
                                            &darr;
                                        @endif
                                    @endif
                                </a>
                            </th>
                            <th scope="col">
                                <a class="quickaction-anchor sort" href="{{ route('computer.index', array_merge(request()->except(['sort', 'direction']), ['sort' => 'ram', 'direction' => request('sort') === 'ram' && request('direction') === 'asc' ? 'desc' : 'asc'])) }}">
                                    RAM
                                    @if(request('sort') === 'ram')
                                        @if(request('direction') === 'asc')
                                            &uarr;
                                        @else
                                            &darr;
                                        @endif
                                    @endif
                                </a>
                            </th>
                            <th scope="col">
                                <a class="quickaction-anchor sort" href="{{ route('computer.index', array_merge(request()->except(['sort', 'direction']), ['sort' => 'storage', 'direction' => request('sort') === 'storage' && request('direction') === 'asc' ? 'desc' : 'asc'])) }}">
                                    Storage
                                    @if(request('sort') === 'storage')
                                        @if(request('direction') === 'asc')
                                            &uarr;
                                        @else
                                            &darr;
                                        @endif
                                    @endif
                                </a>
                            </th>
                            <th scope="col">
                                <a class="quickaction-anchor sort" href="{{ route('computer.index', array_merge(request()->except(['sort', 'direction']), ['sort' => 'color', 'direction' => request('sort') === 'color' && request('direction') === 'asc' ? 'desc' : 'asc'])) }}">
                                    Colour
                                    @if(request('sort') === 'color')
                                        @if(request('direction') === 'asc')
                                            &uarr;
                                        @else
                                            &darr;
                                        @endif
                                    @endif
                                </a>
                            </th>
                            <th scope="col">
                                <a class="quickaction-anchor sort" href="{{ route('computer.index', array_merge(request()->except(['sort', 'direction']), ['sort' => 'keyboard_layout_id', 'direction' => request('sort') === 'keyboard_layout_id' && request('direction') === 'asc' ? 'desc' : 'asc'])) }}">
                                    Keyboard Layout
                                    @if(request('sort') === 'keyboard_layout_id')
                                        @if(request('direction') === 'asc')
                                            &uarr;
                                        @else
                                            &darr;
                                        @endif
                                    @endif
                                </a>
                            </th>
                            <th scope="col">
                                <a class="quickaction-anchor sort" href="{{ route('computer.index', array_merge(request()->except(['sort', 'direction']), ['sort' => 'location_id', 'direction' => request('sort') === 'location_id' && request('direction') === 'asc' ? 'desc' : 'asc'])) }}">
                                    Location
                                    @if(request('sort') === 'location_id')
                                        @if(request('direction') === 'asc')
                                            &uarr;
                                        @else
                                            &darr;
                                        @endif
                                    @endif
                                </a>
                            </th>
                            <th scope="col">
                                <a class="quickaction-anchor sort" href="{{ route('computer.index', array_merge(request()->except(['sort', 'direction']), ['sort' => 'purchase_date', 'direction' => request('sort') === 'purchase_date' && request('direction') === 'asc' ? 'desc' : 'asc'])) }}">
                                    Purchase Date
                                    @if(request('sort') === 'purchase_date')
                                        @if(request('direction') === 'asc')
                                            &uarr;
                                        @else
                                            &darr;
                                        @endif
                                    @endif
                                </a>
                            </th>
                            <th scope="col">
                                <a class="quickaction-anchor sort" href="{{ route('computer.index', array_merge(request()->except(['sort', 'direction']), ['sort' => 'warranty_date', 'direction' => request('sort') === 'warranty_date' && request('direction') === 'asc' ? 'desc' : 'asc'])) }}">
                                    Warranty Expiration
                                    @if(request('sort') === 'warranty_date')
                                        @if(request('direction') === 'asc')
                                            &uarr;
                                        @else
                                            &darr;
                                        @endif
                                    @endif
                                </a>
                            </th>
                            <th scope="col">
                                <a class="quickaction-anchor sort" href="{{ route('computer.index', array_merge(request()->except(['sort', 'direction']), ['sort' => 'notes', 'direction' => request('sort') === 'notes' && request('direction') === 'asc' ? 'desc' : 'asc'])) }}">
                                    Notes
                                    @if(request('sort') === 'notes')
                                        @if(request('direction') === 'asc')
                                            &uarr;
                                        @else
                                            &darr;
                                        @endif
                                    @endif
                                </a>
                            </th>
                            <th scope="col">Invoice</th>
                            <th scope="col">
                                <a class="quickaction-anchor sort" href="{{ route('computer.index', array_merge(request()->except(['sort', 'direction']), ['sort' => 'supplier_id', 'direction' => request('sort') === 'supplier_id' && request('direction') === 'asc' ? 'desc' : 'asc'])) }}">
                                    Supplier
                                    @if(request('sort') === 'supplier_id')
                                        @if(request('direction') === 'asc')
                                            &uarr;
                                        @else
                                            &darr;
                                        @endif
                                    @endif
                                </a>
                            </th>
                            <th scope="col">
                                <a class="quickaction-anchor sort" href="{{ route('computer.index', array_merge(request()->except(['sort', 'direction']), ['sort' => 'user_id', 'direction' => request('sort') === 'user_id' && request('direction') === 'asc' ? 'desc' : 'asc'])) }}">
                                    Person
                                    @if(request('sort') === 'user_id')
                                        @if(request('direction') === 'asc')
                                            &uarr;
                                        @else
                                            &darr;
                                        @endif
                                    @endif
                                </a>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($computers as $computer)
                            <tr>
                                <td style="text-align: center">
                                    <a href="{{ route('computer.show', $computer->id) }}" class="quickaction-anchor view">
                                        <span class="material-icons">
                                            visibility
                                        </span>
                                    </a>
                                </td>
                                <td style="text-align: center">
                                    <a href="{{ route('computer.edit', $computer->id) }}" class="quickaction-anchor edit">
                                        <span class="material-icons">
                                            edit
                                        </span>
                                    </a>
                                </td>
                                <td style="text-align: center">
                                    <a href="{{ route('computer.copy', $computer->id) }}" class="quickaction-anchor copy">
                                        <span class="material-icons">
                                            content_copy
                                        </span>
                                    </a>
                                </td>
                                <td style="text-align: center">
                                    <form class="deleteForm" data-type="{{ $computer->type->name ?? "Computer" }}" data-model="{{ $computer->model }}" action="{{ route('computer.destroy', $computer->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="delete">
                                            <span class="material-icons">
                                                delete
                                            </span>
                                        </button>
                                    </form>
                                </td>
                                <td>{{ optional($computer->type)->name }}</td>
                                <td>{{ optional($computer->manufacturer)->name }}</td>
                                <td>{{ $computer->model }}</td>
                                <td>{{ $computer->serial_number }}</td>
                                <td>{{ $computer->product_number }}</td>
                                <td>{{ $computer->mac_address }}</td>
                                <td>{{ $computer->network_name }}</td>
                                <td>{{ optional($computer->operatingSystem)->name }}</td>
                                <td>{{ $computer->cpu }}</td>
                                <td>{{ $computer->ram }}</td>
                                <td>{{ $computer->storage }}</td>
                                <td>{{ $computer->color }}</td>
                                <td>{{ optional($computer->keyboardLayout)->name }}</td>
                                <td>{{ optional($computer->location)->name }}</td>
                                <td>{{ $computer->purchase_date }}</td>
                                <td>{{ $computer->warranty_date }}</td>
                                <td>{!! nl2br(e($computer->notes)) !!}</td>
                                <td>
                                    @if ($computer->invoice)
                                        <a href="{{ route('admin.inventory.invoice.download', $computer->invoice) }}" target="_blank">View Invoice</a>
                                    @endif
                                </td>
                                <td>{{ optional($computer->supplier)->name }}</td>
                                <td>{{ optional($computer->person)->first_name }} {{ optional($computer->person)->last_name }}</td>
                            </tr>
                        @endforeach
                        @if ($computers->isEmpty())
                            <tr>
                                <td colspan="24">No computers found.</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
            {{ $computers->withQueryString()->links('pagination.uzh-pagination-en') }}
        </div>
    </div>
</x-layout>
<script>
    $(document).ready(function() {
        // opens confirmation modal
        function showModal(message) {
            $('#confirmationMessage').html(message);
            $('#confirmModal').css('display', 'block');
        }

        // closes confirmation modal and removes listeners
        function closeModal() {
            $('#confirmModal').css('display', 'none');
            $('#confirmButton').off('click');
            $('#cancelButton').off('click');
        }

        // creates custom confirm modal by using promises
        function customConfirm(message) {
            return new Promise(function (resolve, reject) {
                // opens modal
                showModal(message);

                // attaches listeners to buttons
                $('#confirmButton').on('click', function () {
                    // closes modal
                    closeModal();
                    // returns confirmation
                    resolve(true);
                });

                $('#cancelButton').on('click', function () {
                    // closes modal
                    closeModal();
                    // returns rejection
                    resolve(false);
                });
            });
        }

        // listens for delete button click
        $('.delete').on('click', function() {
            // retrieves form of clicked button
            var form = $(this).closest('.deleteForm');
            // retrieves name of computer
            var type = form.data('type');
            var model = form.data('model');
            // opens confirmation modal
            customConfirm('Are you sure you want to delete the ' + type + ' <b style="font-weight: bold;">' + model + '</b>?')
                .then(function (result) {
                    // if confirmed, submits form
                    if (result) {
                        form.off('submit', handleFormSubmission).submit();
                        form.on('submit', handleFormSubmission);
                    }
                });
        });

        // prevents form from submitting when confirmation modal is open
        function handleFormSubmission(event) {
            event.preventDefault();
        }

        // attaches listener to form
        $('.deleteForm').on('submit', handleFormSubmission);

        $('#expandSurface').on('click', function() {
            $('#expandable').slideToggle(300);

            if ($(this).text() == 'Filter (click to expand)') {
                $(this).text('Filter (click to collapse)');
            } else {
                $(this).text('Filter (click to expand)');
            }
        });

        $('.selectFilter').selectize({
            create: false,
            sortField: 'text'
        });
    });
</script>
