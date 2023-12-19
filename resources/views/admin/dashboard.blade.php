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
                            Personal data
                            <x-slot:route>
                                {{ route('admin.personal') }}
                            </x-slot:route>
                            <x-slot:image>
                                personal_data.svg
                            </x-slot:image>
                            <x-slot:details>
                                CV, ORCID, Transversal research area, ...
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
                                Creating, managing and updating completed and ongoing research projects
                            </x-slot:details>
                        </x-navtile>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-layout>
