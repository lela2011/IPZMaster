<x-layout>
    <x-back>
        <x-slot:route>
            {{ route('home') }}
        </x-slot:route>
        Return to dashboard
    </x-back>
    <section class="ContentArea">
        <div class="TextImage">
            <div class="TextImage--inner">
                <div class="TextImage--content">
                    <div class="flex-container">
                        <x-navtile>
                            Inventory
                            <x-slot:route>
                                {{ route('admin.inventory.dashboard') }}
                            </x-slot:route>
                            <x-slot:image>
                                inventory.svg
                            </x-slot:image>
                            <x-slot:details>
                                Manage inventory
                            </x-slot:details>
                        </x-navtile>
                        <x-navtile>
                            Personal Data
                            <x-slot:route>
                                {{ route('admin.personal') }}
                            </x-slot:route>
                            <x-slot:image>
                                personal_data.svg
                            </x-slot:image>
                            <x-slot:details>
                                CV, ORCID, Research Areas, ...
                            </x-slot:details>
                        </x-navtile>
                        <x-navtile>
                            Research Projects
                            <x-slot:route>
                                {{ route('admin.research') }}
                            </x-slot:route>
                            <x-slot:image>
                                research_projects.svg
                            </x-slot:image>
                            <x-slot:details>
                                Creating, Managing and Updating Completed and Ongoing Research Projects
                            </x-slot:details>
                        </x-navtile>
                        <x-navtile>
                            Press Information
                            <x-slot:route>
                                {{ route('admin.media') }}
                            </x-slot:route>
                            <x-slot:image>
                                press_information.svg
                            </x-slot:image>
                            <x-slot:details>
                                Competences and Preferred Contact Method
                            </x-slot:details>
                        </x-navtile>
                        <x-navtile>
                            Research Areas
                            <x-slot:route>
                                {{ route('admin.research-area') }}
                            </x-slot:route>
                            <x-slot:image>
                                research_area.svg
                            </x-slot:image>
                            <x-slot:details>
                                Manage Research Area
                            </x-slot:details>
                        </x-navtile>
                        <x-navtile>
                            Files
                            <x-slot:route>
                                {{ route('file.index') }}
                            </x-slot:route>
                            <x-slot:image>
                                file.svg
                            </x-slot:image>
                            <x-slot:details>
                                Upload and Manage Files
                            </x-slot:details>
                        </x-navtile>
                        <x-navtile>
                            Employment Types
                            <x-slot:route>
                                {{ route('admin.employment-type.index') }}
                            </x-slot:route>
                            <x-slot:image>
                                employment_type.svg
                            </x-slot:image>
                            <x-slot:details>
                                Create, update, delete and order employment types
                            </x-slot:details>
                        </x-navtile>
                        <x-navtile>
                            Transversal Research Priorities
                            <x-slot:route>
                                {{ route('admin.transversal-research-prio.index') }}
                            </x-slot:route>
                            <x-slot:image>
                                priorities.svg
                            </x-slot:image>
                            <x-slot:details>
                                Create, update and delete transversal research priorities
                            </x-slot:details>
                        </x-navtile>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-layout>
