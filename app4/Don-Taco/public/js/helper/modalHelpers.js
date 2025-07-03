export function attachInfoToAltEditorModal({ message, fieldAfterId, alertId = 'alert-info-message' }) {
    const createAlertBlock = () => {
        const activeModal = document.querySelector('.modal.show');
        if (!activeModal) {
            console.log('[modalHelpers] No active modal with class .show');
            return;
        }

        const form = activeModal.querySelector('form');
        if (!form) {
            console.warn('[modalHelpers] No form element found');
            return;
        }

        const formId = form.getAttribute('id') || '';

        // Skip if form ID contains "delete"
        if (formId.toLowerCase().includes('delete')) {
            // skip delete modal silently
            return;
        }

        // Only continue if form ID contains "add" or "edit"
        if (!formId.toLowerCase().includes('add') && !formId.toLowerCase().includes('edit')) {
            // skip other modals silently
            return;
        }

        // Remove old alert and button if they exist
        const oldAlert = activeModal.querySelector(`#${alertId}`);
        if (oldAlert) {
            oldAlert.remove();
        }
        const oldBtn = activeModal.querySelector('.alteditor-info-btn');
        if (oldBtn) {
            oldBtn.remove();
        }

        // Find the target field container inside modal
        const target = activeModal.querySelector(`#${fieldAfterId}`);
        if (!target) {
            console.warn(`[modalHelpers] Could not find target field with id "${fieldAfterId}" inside modal`);
            return;
        }

        // Insert alert block after target
        const alertHtml = `
            <div id="${alertId}" class="form-group row mt-2">
                <div class="collapse" id="collapseInfo">
                    <div class="alert alert-warning mb-0" role="alert">${message}</div>
                </div>
            </div>
        `;
        target.insertAdjacentHTML('afterend', alertHtml);

        // Insert toggle button in modal footer (left aligned)
        const footer = activeModal.querySelector('.modal-footer');
        if (!footer) {
            console.warn('[modalHelpers] No modal footer found');
            return;
        }
        const btnWrapper = document.createElement('div');
            btnWrapper.className = 'me-auto';
            btnWrapper.innerHTML = `
            <button class="btn btn-warning alteditor-info-btn" type="button"
                data-bs-toggle="collapse"
                data-bs-target="#collapseInfo"
                aria-expanded="false"
                aria-controls="collapseInfo">
                Mostrar información importante
            </button>
        `;
        footer.prepend(btnWrapper);
    };

    if (
        typeof $.fn.dataTable !== 'undefined' &&
        typeof $.fn.dataTable.altEditor === 'function' &&
        !$.fn.dataTable.altEditor._customOpenDialogHookApplied
    ) {
        $.fn.dataTable.altEditor._customOpenDialogHookApplied = true;

        const originalOpen = $.fn.dataTable.altEditor.prototype.internalOpenDialog;

        $.fn.dataTable.altEditor.prototype.internalOpenDialog = function (selector, onopen) {
            const wrapped = function (...args) {
                try {
                    onopen?.apply(this, args);
                } finally {
                    setTimeout(createAlertBlock, 200); // delay so modal DOM is ready
                }
            };
            return originalOpen.call(this, selector, wrapped);
        };
    } else if (typeof $.fn.dataTable.altEditor !== 'function') {
        console.warn('[modalHelpers] altEditor is not loaded. Cannot attach custom modal behavior.');
    }
}
