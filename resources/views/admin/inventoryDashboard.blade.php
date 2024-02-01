<x-layout>
    <x-back>
        <x-slot:route>
            {{ route('admin.dashboard') }}
        </x-slot:route>
        Return to Admin Dashboard
    </x-back>
    <section class="ContentArea">
        <div class="TextImage">
            <div class="TextImage--inner">
                <div class="TextImage--content">
                    <div class="flex-container">
                        <x-navtile>
                            Computers
                            <x-slot:route>
                                {{ route('computer.index') }}
                            </x-slot:route>
                            <x-slot:image>
                                computer.svg
                            </x-slot:image>
                            <x-slot:details>
                                Manage computers
                            </x-slot:details>
                        </x-navtile>
                        <x-navtile>
                            Mobile Devices
                            <x-slot:route>
                                {{ route('mobile-device.index') }}
                            </x-slot:route>
                            <x-slot:image>
                                mobile_device.svg
                            </x-slot:image>
                            <x-slot:details>
                                Manage mobile devices
                            </x-slot:details>
                        </x-navtile>
                        <x-navtile>
                            Peripherals
                            <x-slot:route>
                                {{ route('peripheral.index') }}
                            </x-slot:route>
                            <x-slot:image>
                                peripheral.svg
                            </x-slot:image>
                            <x-slot:details>
                                Manage peripherals
                            </x-slot:details>
                        </x-navtile>
                        <x-navtile>
                            Printers
                            <x-slot:route>
                                {{ route('printer.index') }}
                            </x-slot:route>
                            <x-slot:image>
                                printer.svg
                            </x-slot:image>
                            <x-slot:details>
                                Manage printers
                            </x-slot:details>
                        </x-navtile>
                        <x-navtile>
                            Monitors
                            <x-slot:route>
                                {{ route('monitor.index') }}
                            </x-slot:route>
                            <x-slot:image>
                                monitor.svg
                            </x-slot:image>
                            <x-slot:details>
                                Manage monitors
                            </x-slot:details>
                        </x-navtile>
                        <x-navtile>
                            Software
                            <x-slot:route>
                                {{ route('software.index') }}
                            </x-slot:route>
                            <x-slot:image>
                                software.svg
                            </x-slot:image>
                            <x-slot:details>
                                Manage softwares
                            </x-slot:details>
                        </x-navtile>
                        <x-navtile>
                            Computer Types
                            <x-slot:route>
                                {{ route('computer-type.index') }}
                            </x-slot:route>
                            <x-slot:image>
                                computer.svg
                            </x-slot:image>
                            <x-slot:details>
                                Manage computer types
                            </x-slot:details>
                        </x-navtile>
                        <x-navtile>
                            Mobile Device Types
                            <x-slot:route>
                                {{ route('mobile-device-type.index') }}
                            </x-slot:route>
                            <x-slot:image>
                                mobile_device.svg
                            </x-slot:image>
                            <x-slot:details>
                                Manage mobile device types
                            </x-slot:details>
                        </x-navtile>
                        <x-navtile>
                            Peripheral Types
                            <x-slot:route>
                                {{ route('peripheral-type.index') }}
                            </x-slot:route>
                            <x-slot:image>
                                peripheral.svg
                            </x-slot:image>
                            <x-slot:details>
                                Manage peripheral types
                            </x-slot:details>
                        </x-navtile>
                        <x-navtile>
                            Locations
                            <x-slot:route>
                                {{ route('location.index') }}
                            </x-slot:route>
                            <x-slot:image>
                                location.svg
                            </x-slot:image>
                            <x-slot:details>
                                Manage locations
                            </x-slot:details>
                        </x-navtile>
                        <x-navtile>
                            Keyboard Layouts
                            <x-slot:route>
                                {{ route('keyboard-layout.index') }}
                            </x-slot:route>
                            <x-slot:image>
                                keyboard.svg
                            </x-slot:image>
                            <x-slot:details>
                                Manage keyboard layouts
                            </x-slot:details>
                        </x-navtile>
                        <x-navtile>
                            Operating Systems
                            <x-slot:route>
                                {{ route('operating-system.index') }}
                            </x-slot:route>
                            <x-slot:image>
                                operating_system.svg
                            </x-slot:image>
                            <x-slot:details>
                                Manage operating systems
                            </x-slot:details>
                        </x-navtile>
                        <x-navtile>
                            Manufacturers
                            <x-slot:route>
                                {{ route('manufacturer.index') }}
                            </x-slot:route>
                            <x-slot:image>
                                manufacturer.svg
                            </x-slot:image>
                            <x-slot:details>
                                Manage manufacturers
                            </x-slot:details>
                        </x-navtile>
                        <x-navtile>
                            Suppliers
                            <x-slot:route>
                                {{ route('supplier.index') }}
                            </x-slot:route>
                            <x-slot:image>
                                supplier.svg
                            </x-slot:image>
                            <x-slot:details>
                                Manage suppliers
                            </x-slot:details>
                        </x-navtile>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-layout>
