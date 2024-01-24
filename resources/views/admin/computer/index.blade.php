<x-layout>
    <div class="ContentArea">
        <x-confirm-modal />
        <x-flash-message />
        <div class="TextImage" style="display: flex; justify-content: space-between; flex-wrap: wrap;">
            <a href="{{ route('admin.inventory.dashboard') }}" class="Button color-border-white size-large" style="margin-bottom: 8px">
                <i class="fa fa-arrow-left" style="margin-right: 8px; vertical-align: bottom"></i>
                Return to Inventory Dashboard
            </a>
        </div>
        <div class="TextImage">
            <h2 class="TextImage--title richtext">
                Computers
            </h2>
        </div>
        <div class="TextImage">
            <div class="TextImage--content richtext" style="overflow-x: scroll">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">Type</th>
                            <th scope="col">Manufacturer</th>
                            <th scope="col">Model</th>
                            <th scope="col">Serial Number</th>
                            <th scope="col">Product Number</th>
                            <th scope="col">MAC Address</th>
                            <th scope="col">Network Name</th>
                            <th scope="col">Operating System</th>
                            <th scope="col">CPU</th>
                            <th scope="col">RAM</th>
                            <th scope="col">Storage</th>
                            <th scope="col">Color</th>
                            <th scope="col">Keyboard Layout</th>
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
                        <tr>
                            <td>Bla</td>
                            <td>Bla</td>
                            <td>Bla</td>
                            <td>Bla</td>
                            <td>Bla</td>
                            <td>Bla</td>
                            <td>Bla</td>
                            <td>Bla</td>
                            <td>Bla</td>
                            <td>Bla</td>
                            <td>Bla</td>
                            <td>Bla</td>
                            <td>Bla</td>
                            <td>Bla</td>
                            <td>Bla</td>
                            <td>Bla</td>
                            <td>Bla</td>
                            <td>Bla</td>
                            <td>Bla</td>
                            <td>Bla</td>
                        </tr>
                        <tr>
                            <td>Blai</td>
                            <td>Blai</td>
                            <td>Blai</td>
                            <td>Blai</td>
                            <td>Blai</td>
                            <td>Blai</td>
                            <td>Blai</td>
                            <td>Blai</td>
                            <td>Blai</td>
                            <td>Blai</td>
                            <td>Blai</td>
                            <td>Blai</td>
                            <td>Blai</td>
                            <td>Blai</td>
                            <td>Blai</td>
                            <td>Blai</td>
                            <td>Blai</td>
                            <td>Blai</td>
                            <td>Blai</td>
                            <td>Blai</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layout>
