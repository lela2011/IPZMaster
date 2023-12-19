<div class="TextImage">
    <div class="TextImage--inner">
        <div class="TextImage--content">
            <div class="flex-container">
                @if (Auth::user()->adminLevel > 0)
                    <x-navtile>
                        Admin Panel
                        <x-slot:route>
                            {{ route('admin.dashboard') }}
                        </x-slot:route>
                        <x-slot:image>
                            admin.svg
                        </x-slot:image>
                        <x-slot:details>
                            Manage all Users, Research Projects, ...
                        </x-slot:details>
                    </x-navtile>
                @endif
                <x-navtile>
                    Personal data
                    <x-slot:route>
                        {{ route('personal.show', Auth::user()->uid) }}
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
                        {{ route('media.show', Auth::user()->uid) }}
                    </x-slot:route>
                    <x-slot:image>
                        press_information.svg
                    </x-slot:image>
                    <x-slot:details>
                        Competences and Preferred contact method
                    </x-slot:details>
                </x-navtile>
                <x-navtile>
                    External contacts
                    <x-slot:route>
                        {{ route('externalContact.index') }}
                    </x-slot:route>
                    <x-slot:image>
                        external_contact.svg
                    </x-slot:image>
                    <x-slot:details>
                        Create, manage and update external contacts
                    </x-slot:details>
                </x-navtile>
                <x-navtile>
                    Competences
                    <x-slot:route>
                        {{ route('competence.index') }}
                    </x-slot:route>
                    <x-slot:image>
                        competences.svg
                    </x-slot:image>
                    <x-slot:details>
                        Create, manage and update external contacts
                    </x-slot:details>
                </x-navtile>
            </div>
        </div>
    </div>
</div>
