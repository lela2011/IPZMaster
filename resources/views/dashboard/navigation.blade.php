<section class="ContentArea">
    <div class="TextImage">
        <div class="TextImage--inner">
            <div class="TextImage--content">
                <div class="flex-container">
                    <x-navtile>
                        Persönliche Daten
                        <x-slot:route>
                            /bla
                        </x-slot:route>
                        <x-slot:image>
                            personal_data.svg
                        </x-slot:image>
                        <x-slot:details>
                            CV, ORCID, transversale Forschungsbereiche, ...
                        </x-slot:details>
                    </x-navtile>
                    <x-navtile>
                        <x-slot:route>
                            /bla2
                        </x-slot:route>
                        <x-slot:image>
                            press_information.svg
                        </x-slot:image>
                        <x-slot:details>
                            Kompetenzen, Kontaktaufnahme, ...
                        </x-slot:details>
                        Medienauskunft
                    </x-navtile>
                </div>
            </div>
        </div>
    </div>
</section>
