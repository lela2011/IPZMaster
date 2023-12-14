<div id="externalContactModal" class="modal">
    <div class="modal-overlay" id="modalOverlay"></div>
    <div class="modal-content">
        <span class="close-btn" id="closeModal">&times;</span>
        <h2>Add external Contact</h2>
        <form id="externalContactForm" method="POST" novalidate>
            <div class="FormInput">
                <label class="FormLabel" for="contactName">Name:</label>
                <input class="Input" type="text" id="contactName" name="contactName">
                <p class="has-error" id="emptyNameError" style="color: red; display: none">
                    <small>
                        Name may not be empty
                    </small>
                </p>
            </div>
            <div class="FormInput">
                <label class="FormLabel" for="contactEmail">Email:</label>
                <input class="Input" type="email" id="contactMail" name="contactEmail">
                <p class="has-error" id="emptyMailError" style="color: red; display: none">
                    <small>
                        E-Mail may not be empty
                    </small>
                </p>
                <p class="has-error" id="invalidMailError" style="color: red; display: none">
                    <small>
                        Provided e-mail is not valid
                    </small>
                </p>
                <p class="has-error" id="duplicateMailError" style="color: red; display: none">
                    <small>
                        The provided e-mail already exists
                    </small>
                </p>
            </div>
            <div class="FormInput">
                <label class="FormLabel" for="organization">Organization:</label>
                <input class="Input" type="text" id="organization" name="organization">
            </div>
            <div class="FormButtons" style="margin-top: 2rem">
                <div style="display: flex; align-items: center" id="validationSpinner">
                    <div class="loader"></div>
                    <span style="margin-left: 8px; color: forestgreen">Validating input</span>
                </div>
                <button class="Button color-primary size-large" type="submit">
                    <span class="Button--inner">
                        Create external contact
                    </span>
                </button>
            </div>
        </form>
    </div>
</div>
