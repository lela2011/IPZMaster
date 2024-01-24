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
                            Printer
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
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-layout>
