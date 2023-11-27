
<div class="TextImage">
    <div class="TextImage--inner">
        <div class="TextImage--content">
            <div class="flex-container">
                <x-navtile>
                    Personal data
                    <x-slot:route>
                        {{ route('personal') }}
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
                        {{ route('research.index') }}
                    </x-slot:route>
                    <x-slot:image>
                        research_projects.svg
                    </x-slot:image>
                    <x-slot:details>
                        Creating, managing and updating completed and ongoing research projects
                    </x-slot:details>
                </x-navtile>
                <x-navtile>
                    Press information
                    <x-slot:route>
                        {{ route('media') }}
                    </x-slot:route>
                    <x-slot:image>
                        press_information.svg
                    </x-slot:image>
                    <x-slot:details>
                        Competences, Preferred contact method, ...
                    </x-slot:details>
                </x-navtile>
            </div>
        </div>
    </div>
</div>
