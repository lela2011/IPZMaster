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
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-layout>
