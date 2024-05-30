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
            <a href="{{ route('software.create') }}" class="Button color-border-white size-large"
                style="margin-bottom: 8px">
                Add new Software
                <i class="fa fa-arrow-right" style="margin-left: 8px; vertical-align: bottom"></i>
            </a>
        </div>
        <div class="TextImage">
            <h2 class="TextImage--title richtext">
                Softwares
            </h2>
        </div>
        <form class="js-Form Form" action="{{ route('software.index') }}" method="GET">
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
                        <label class="FormLabel" for="name">Name</label>
                        <input class="Input" type="text" name="name" id="name" value="{{ optional($filters)['name'] }}">
                    </div>
                    <div class="FormInput">
                        <label class="FormLabel" for="license_type">License Type</label>
                        <input class="Input" type="text" name="license_type" id="license_type" value="{{ optional($filters)['license_type'] }}">
                    </div>
                    <div class="FormInput">
                        <label class="FormLabel" for="purchase_date">Purchase Date</label>
                        <input class="Input" type="date" name="purchase_date" id="purchase_date" value="{{ optional($filters)['purchase_date'] }}">
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
                        <label class="FormLabel" for="quantity">Quantity</label>
                        <input class="Input" type="text" name="quantity" id="quantity" value="{{ optional($filters)['quantity'] }}">
                    </div>
                    <div class="FormInput">
                        <label class="FormLabel" for="user_id">Person</label>
                        <select class="selectFilter" name="people" id="people" multiple>
                            @foreach ($people as $person)
                                <option value="{{ $person->uid }}" @if(collect(optional($filters)['user_id'])->contains($person->uid)) selected @endif>{{ $person->first_name }} {{ $person->last_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="FormButtons">
                        <a href="{{route('software.index')}}" class="Button color-border-white size-large">
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
                                <a class="quickaction-anchor sort" href="{{ route('software.index', array_merge(request()->except(['sort', 'direction']), ['sort' => 'manufacturer_id', 'direction' => request('sort') === 'manufacturer_id' && request('direction') === 'asc' ? 'desc' : 'asc'])) }}">
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
                                <a class="quickaction-anchor sort" href="{{ route('software.index', array_merge(request()->except(['sort', 'direction']), ['sort' => 'name', 'direction' => request('sort') === 'name' && request('direction') === 'asc' ? 'desc' : 'asc'])) }}">
                                    Name
                                    @if(request('sort') === 'name')
                                        @if(request('direction') === 'asc')
                                            &uarr;
                                        @else
                                            &darr;
                                        @endif
                                    @endif
                                </a>
                            </th>
                            <th scope="col">
                                <a class="quickaction-anchor sort" href="{{ route('software.index', array_merge(request()->except(['sort', 'direction']), ['sort' => 'license_type', 'direction' => request('sort') === 'license_type' && request('direction') === 'asc' ? 'desc' : 'asc'])) }}">
                                    License Type
                                    @if(request('sort') === 'license_type')
                                        @if(request('direction') === 'asc')
                                            &uarr;
                                        @else
                                            &darr;
                                        @endif
                                    @endif
                                </a>
                            </th>
                            <th scope="col">
                                <a class="quickaction-anchor sort" href="{{ route('software.index', array_merge(request()->except(['sort', 'direction']), ['sort' => 'purchase_date', 'direction' => request('sort') === 'purchase_date' && request('direction') === 'asc' ? 'desc' : 'asc'])) }}">
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
                                <a class="quickaction-anchor sort" href="{{ route('software.index', array_merge(request()->except(['sort', 'direction']), ['sort' => 'notes', 'direction' => request('sort') === 'notes' && request('direction') === 'asc' ? 'desc' : 'asc'])) }}">
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
                                <a class="quickaction-anchor sort" href="{{ route('software.index', array_merge(request()->except(['sort', 'direction']), ['sort' => 'supplier_id', 'direction' => request('sort') === 'supplier_id' && request('direction') === 'asc' ? 'desc' : 'asc'])) }}">
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
                            <th scope="col">Quantity</th>
                            <th scope="col">People</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($softwares as $software)
                            <tr>
                                <td style="text-align: center">
                                    <a href="{{ route('software.show', $software->id) }}" class="quickaction-anchor view">
                                        <span class="material-icons">
                                            visibility
                                        </span>
                                    </a>
                                </td>
                                <td style="text-align: center">
                                    <a href="{{ route('software.edit', $software->id) }}" class="quickaction-anchor edit">
                                        <span class="material-icons">
                                            edit
                                        </span>
                                    </a>
                                </td>
                                <td style="text-align: center">
                                    <a href="{{ route('software.copy', $software->id) }}" class="quickaction-anchor copy">
                                        <span class="material-icons">
                                            content_copy
                                        </span>
                                    </a>
                                </td>
                                <td style="text-align: center">
                                    <form class="deleteForm" data-name="{{ $software->name ?? "Unknown Software" }}" action="{{ route('software.destroy', $software->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="delete">
                                            <span class="material-icons">
                                                delete
                                            </span>
                                        </button>
                                    </form>
                                </td>
                                <td>{{ optional($software->manufacturer)->name }}</td>
                                <td>{{ $software->name }}</td>
                                <td>{{ $software->license_type }}</td>
                                <td>{{ $software->purchase_date }}</td>
                                <td>{!! nl2br(e($software->notes)) !!}</td>
                                <td>
                                    @if ($software->invoice)
                                        <a href="{{ route('admin.inventory.invoice.download', $software->invoice) }}" target="_blank">View Invoice</a>
                                    @endif
                                </td>
                                <td>{{ optional($software->supplier)->name }}</td>
                                <td>{{ $software->people->count() }} / {{ $software->quantity }}</td>
                                <td>
                                    <ul>
                                        @foreach ($software->people as $person)
                                            <li>{{ $person->first_name }} {{ $person->last_name }}</li>
                                        @endforeach
                                    </ul>
                                </td>
                            </tr>
                        @endforeach
                        @if ($softwares->isEmpty())
                            <tr>
                                <td colspan="13">No softwares found.</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
            {{ $softwares->withQueryString()->links('pagination.uzh-pagination-en') }}
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
            // retrieves name of software
            var name = form.data('name');
            // opens confirmation modal
            customConfirm('Are you sure you want to delete the Software <b style="font-weight: bold;">' + name + '</b>?')
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
