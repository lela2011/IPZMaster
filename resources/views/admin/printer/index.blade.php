<x-layout>
    <div class="ContentArea">
        <x-confirm-modal />
        <x-flash-message />
        <div class="TextImage" style="display: flex; justify-content: space-between; flex-wrap: wrap;">
            <a href="{{ route('admin.inventory.dashboard') }}" class="Button color-border-white size-large"
                style="margin-bottom: 8px">
                <span class="material-icons" style="margin-right: 8px">arrow_back</span>
                Return to Inventory Dashboard
            </a>
            <a href="{{ route('printer.create') }}" class="Button color-border-white size-large"
                style="margin-bottom: 8px">
                Add new Printer
                <span class="material-icons" style="margin-left: 8px">arrow_forward</span>
            </a>
        </div>
        <div class="TextImage">
            <h2 class="TextImage--title richtext">
                Printers
            </h2>
        </div>
        <form class="js-Form Form" action="{{ route('printer.index') }}" method="GET">
            <div class="Form--header">
                <h2 id="expandSurface" class="Form--title" style="cursor: pointer">Filter (click to expand)</h2>
            </div>
            <div id="expandable" style="display: none">
                <div class="Form--body">
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
                        <label class="FormLabel" for="ip_address">IP Address</label>
                        <input class="Input" type="text" name="ip_address" id="ip_address" value="{{ optional($filters)['ip_address'] }}">
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
                        <a href="{{route('printer.index')}}" class="Button color-border-white size-large">
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
                                <a class="quickaction-anchor sort" href="{{ route('printer.index', array_merge(request()->except(['sort', 'direction']), ['sort' => 'manufacturer_id', 'direction' => request('sort') === 'manufacturer_id' && request('direction') === 'asc' ? 'desc' : 'asc'])) }}">
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
                                <a class="quickaction-anchor sort" href="{{ route('printer.index', array_merge(request()->except(['sort', 'direction']), ['sort' => 'model', 'direction' => request('sort') === 'model' && request('direction') === 'asc' ? 'desc' : 'asc'])) }}">
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
                                <a class="quickaction-anchor sort" href="{{ route('printer.index', array_merge(request()->except(['sort', 'direction']), ['sort' => 'serial_number', 'direction' => request('sort') === 'serial_number' && request('direction') === 'asc' ? 'desc' : 'asc'])) }}">
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
                                <a class="quickaction-anchor sort" href="{{ route('printer.index', array_merge(request()->except(['sort', 'direction']), ['sort' => 'product_number', 'direction' => request('sort') === 'product_number' && request('direction') === 'asc' ? 'desc' : 'asc'])) }}">
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
                                <a class="quickaction-anchor sort" href="{{ route('printer.index', array_merge(request()->except(['sort', 'direction']), ['sort' => 'mac_address', 'direction' => request('sort') === 'mac_address' && request('direction') === 'asc' ? 'desc' : 'asc'])) }}">
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
                                <a class="quickaction-anchor sort" href="{{ route('printer.index', array_merge(request()->except(['sort', 'direction']), ['sort' => 'network_name', 'direction' => request('sort') === 'network_name' && request('direction') === 'asc' ? 'desc' : 'asc'])) }}">
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
                                <a class="quickaction-anchor sort" href="{{ route('printer.index', array_merge(request()->except(['sort', 'direction']), ['sort' => 'network_name', 'direction' => request('sort') === 'network_name' && request('direction') === 'asc' ? 'desc' : 'asc'])) }}">
                                    IP Address
                                    @if(request('sort') === 'ip_address')
                                        @if(request('direction') === 'asc')
                                            &uarr;
                                        @else
                                            &darr;
                                        @endif
                                    @endif
                                </a>
                            </th>
                            <th scope="col">
                                <a class="quickaction-anchor sort" href="{{ route('printer.index', array_merge(request()->except(['sort', 'direction']), ['sort' => 'location_id', 'direction' => request('sort') === 'location_id' && request('direction') === 'asc' ? 'desc' : 'asc'])) }}">
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
                                <a class="quickaction-anchor sort" href="{{ route('printer.index', array_merge(request()->except(['sort', 'direction']), ['sort' => 'purchase_date', 'direction' => request('sort') === 'purchase_date' && request('direction') === 'asc' ? 'desc' : 'asc'])) }}">
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
                                <a class="quickaction-anchor sort" href="{{ route('printer.index', array_merge(request()->except(['sort', 'direction']), ['sort' => 'warranty_date', 'direction' => request('sort') === 'warranty_date' && request('direction') === 'asc' ? 'desc' : 'asc'])) }}">
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
                                <a class="quickaction-anchor sort" href="{{ route('printer.index', array_merge(request()->except(['sort', 'direction']), ['sort' => 'notes', 'direction' => request('sort') === 'notes' && request('direction') === 'asc' ? 'desc' : 'asc'])) }}">
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
                                <a class="quickaction-anchor sort" href="{{ route('printer.index', array_merge(request()->except(['sort', 'direction']), ['sort' => 'supplier_id', 'direction' => request('sort') === 'supplier_id' && request('direction') === 'asc' ? 'desc' : 'asc'])) }}">
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
                                <a class="quickaction-anchor sort" href="{{ route('printer.index', array_merge(request()->except(['sort', 'direction']), ['sort' => 'user_id', 'direction' => request('sort') === 'user_id' && request('direction') === 'asc' ? 'desc' : 'asc'])) }}">
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
                        @foreach ($printers as $printer)
                            <tr>
                                <td style="text-align: center">
                                    <a href="{{ route('printer.show', $printer->id) }}" class="quickaction-anchor view">
                                        <span class="material-icons">
                                            visibility
                                        </span>
                                    </a>
                                </td>
                                <td style="text-align: center">
                                    <a href="{{ route('printer.edit', $printer->id) }}" class="quickaction-anchor edit">
                                        <span class="material-icons">
                                            edit
                                        </span>
                                    </a>
                                </td>
                                <td style="text-align: center">
                                    <a href="{{ route('printer.copy', $printer->id) }}" class="quickaction-anchor copy">
                                        <span class="material-icons">
                                            content_copy
                                        </span>
                                    </a>
                                </td>
                                <td style="text-align: center">
                                    <form class="deleteForm" data-model="{{ $printer->model }}" action="{{ route('printer.destroy', $printer->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="delete">
                                            <span class="material-icons">
                                                delete
                                            </span>
                                        </button>
                                    </form>
                                </td>
                                <td>{{ optional($printer->manufacturer)->name }}</td>
                                <td>{{ $printer->model }}</td>
                                <td>{{ $printer->serial_number }}</td>
                                <td>{{ $printer->product_number }}</td>
                                <td>{{ $printer->mac_address }}</td>
                                <td>{{ $printer->network_name }}</td>
                                <td>{{ $printer->ip_address }}</td>
                                <td>{{ optional($printer->location)->name }}</td>
                                <td>{{ $printer->purchase_date }}</td>
                                <td>{{ $printer->warranty_date }}</td>
                                <td>{!! nl2br(e($printer->notes)) !!}</td>
                                <td>
                                    @if ($printer->invoice)
                                        <a href="{{ route('admin.inventory.invoice.download', $printer->invoice) }}" target="_blank">View Invoice</a>
                                    @endif
                                </td>
                                <td>{{ optional($printer->supplier)->name }}</td>
                                <td>{{ optional($printer->person)->first_name }} {{ optional($printer->person)->last_name }}</td>
                            </tr>
                        @endforeach
                        @if ($printers->isEmpty())
                            <tr>
                                <td colspan="18">No printers found.</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
            {{ $printers->withQueryString()->links('pagination.uzh-pagination-en') }}
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
            // retrieves name of printer
            var model = form.data('model');
            // opens confirmation modal
            customConfirm('Are you sure you want to delete the printer <b style="font-weight: bold;">' + model + '</b>?')
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
