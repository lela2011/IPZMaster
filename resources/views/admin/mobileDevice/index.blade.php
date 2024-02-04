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
            <a href="{{ route('mobile-device.create') }}" class="Button color-border-white size-large"
                style="margin-bottom: 8px">
                Add new Mobile Device
                <i class="fa fa-arrow-right" style="margin-left: 8px; vertical-align: bottom"></i>
            </a>
        </div>
        <div class="TextImage">
            <h2 class="TextImage--title richtext">
                Mobile Devices
            </h2>
        </div>
        <form class="js-Form Form" action="{{ route('mobile-device.index') }}" method="GET">
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
                        <label class="FormLabel" for="network_name">Network Name</label>
                        <input class="Input" type="text" name="network_name" id="network_name" value="{{ optional($filters)['network_name'] }}">
                    </div>
                    <div class="FormInput">
                        <label class="FormLabel" for="imei">IMEI</label>
                        <input class="Input" type="text" name="imei" id="imei" value="{{ optional($filters)['imei'] }}">
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
                        <label class="FormLabel" for="storage">Storage</label>
                        <input class="Input" type="text" name="storage" id="storage" value="{{ optional($filters)['storage'] }}">
                    </div>
                    <div class="FormInput">
                        <label class="FormLabel" for="color">Colour</label>
                        <input class="Input" type="text" name="color" id="color" value="{{ optional($filters)['color'] }}">
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
                        <a href="{{route('mobile-device.index')}}" class="Button color-border-white size-large">
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
                            <th scope="col" colspan="3">Actions</th>
                            <th scope="col">Type</th>
                            <th scope="col">Manufacturer</th>
                            <th scope="col">Model</th>
                            <th scope="col">Serial Number</th>
                            <th scope="col">Product Number</th>
                            <th scope="col">Network Name</th>
                            <th scope="col">IMEI</th>
                            <th scope="col">Operating System</th>
                            <th scope="col">Storage</th>
                            <th scope="col">Colour</th>
                            <th scope="col">Location</th>
                            <th scope="col">Purchase Date</th>
                            <th scope="col">Warranty Expiration</th>
                            <th scope="col">Notes</th>
                            <th scope="col">Invoice</th>
                            <th scope="col">Supplier</th>
                            <th scope="col">Person</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($mobileDevices as $mobileDevice)
                            <tr>
                                <td style="text-align: center">
                                    <a href="{{ route('mobile-device.show', $mobileDevice->id) }}" class="quickaction-anchor view">
                                        <span class="material-icons">
                                            visibility
                                        </span>
                                    </a>
                                </td>
                                <td style="text-align: center">
                                    <a href="{{ route('mobile-device.edit', $mobileDevice->id) }}" class="quickaction-anchor edit">
                                        <span class="material-icons">
                                            edit
                                        </span>
                                    </a>
                                </td>
                                <td style="text-align: center">
                                    <form class="deleteForm" data-type="{{ $mobileDevice->type->name ?? "Mobile Device" }}" data-model="{{ $mobileDevice->model }}" action="{{ route('mobile-device.destroy', $mobileDevice->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="delete">
                                            <span class="material-icons">
                                                delete
                                            </span>
                                        </button>
                                    </form>
                                </td>
                                <td>{{ optional($mobileDevice->type)->name }}</td>
                                <td>{{ optional($mobileDevice->manufacturer)->name }}</td>
                                <td>{{ $mobileDevice->model }}</td>
                                <td>{{ $mobileDevice->serial_number }}</td>
                                <td>{{ $mobileDevice->product_number }}</td>
                                <td>{{ $mobileDevice->network_name }}</td>
                                <td>{{ $mobileDevice->imei }}</td>
                                <td>{{ optional($mobileDevice->operatingSystem)->name }}</td>
                                <td>{{ $mobileDevice->storage }}</td>
                                <td>{{ $mobileDevice->color }}</td>
                                <td>{{ optional($mobileDevice->location)->name }}</td>
                                <td>{{ $mobileDevice->purchase_date }}</td>
                                <td>{{ $mobileDevice->warranty_date }}</td>
                                <td>{!! nl2br(e($mobileDevice->notes)) !!}</td>
                                <td>
                                    @if ($mobileDevice->invoice)
                                        <a href="{{ route('admin.inventory.invoice.download', $mobileDevice->invoice) }}" target="_blank">View Invoice</a>
                                    @endif
                                </td>
                                <td>{{ optional($mobileDevice->supplier)->name }}</td>
                                <td>{{ optional($mobileDevice->person)->first_name }} {{ optional($mobileDevice->person)->last_name }}</td>
                            </tr>
                        @endforeach
                        @if ($mobileDevices->isEmpty())
                            <tr>
                                <td colspan="20">No mobile devices found.</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
            {{ $mobileDevices->withQueryString()->links('pagination.uzh-pagination-en') }}
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
