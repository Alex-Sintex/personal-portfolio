export function attachInfoToAltEditorModal({ message, fieldAfterId, alertId = 'alert-info-message' }) {
    const createAlertBlock = () => {
        if (document.getElementById(alertId)) return; // Prevent duplicates

        const alertHtml = `
            <div id="${alertId}" class="form-group row mt-3">
                
                    <button class="btn btn-primary mb-2" type="button" data-bs-toggle="collapse" data-bs-target="#collapseInfo" aria-expanded="true" aria-controls="collapseInfo">
                        Mostrar información importante
                    </button>
                    <div class="collapse hide" id="collapseInfo">
                        <div class="card card-body">
                            <div class="alert alert-primary mb-0" role="alert">${message}</div>
                        </div>
                    </div>
                
            </div>
        `;

        const target = document.getElementById(fieldAfterId);
        if (target) {
            target.insertAdjacentHTML('afterend', alertHtml);
        } else {
            console.warn(`[modalHelpers] No se encontró el campo con id ${fieldAfterId}`);
        }
    };

    // Patch altEditor once
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
                    setTimeout(createAlertBlock, 100); // Let DOM build first
                }
            };
            return originalOpen.call(this, selector, wrapped);
        };
    } else if (typeof $.fn.dataTable.altEditor !== 'function') {
        console.warn('[modalHelpers] altEditor is not loaded. Cannot attach custom modal behavior.');
    }
}