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
                    Personal Data
                    <x-slot:route>
                        {{ route('personal.show', Auth::user()->uid) }}
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
                        {{ route('research.index') }}
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
                        {{ route('media.show', Auth::user()->uid) }}
                    </x-slot:route>
                    <x-slot:image>
                        press_information.svg
                    </x-slot:image>
                    <x-slot:details>
                        Competences and Preferred Contact Method
                    </x-slot:details>
                </x-navtile>
                <x-navtile>
                    External Contacts
                    <x-slot:route>
                        {{ route('externalContact.index') }}
                    </x-slot:route>
                    <x-slot:image>
                        external_contact.svg
                    </x-slot:image>
                    <x-slot:details>
                        Create, Manage and Update External Contacts
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
                        Create, Manage and Update Competences
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
