/**
 * Format a number as currency (USD).
 * @param {number|string} data - Value to format.
 * @param {string} type - Context (e.g., 'display', 'filter').
 * @param {object} row - (Optional) Full row data.
 * @returns {string|number}
 */
export function currencyRender(data, type, row) {
  if ((type === 'display' || type === 'filter') && !isNaN(data)) {
    return parseFloat(data).toLocaleString('en-US', {
      style: 'currency',
      currency: 'USD'
    });
  }
  return data;
}

/**
 * Check fields marked as required in columnDefs.
 * - if required:true => check empty
 * - if required:false or missing => skip
 */
export function checkRequiredFields(data, columnDefs, errorCallback, toast) {
  for (let colDef of columnDefs) {
    if (!colDef.required) continue; // only required fields

    const value = data[colDef.data];
    const title = colDef.title;

    if (colDef.typeof === "string" || colDef.typeof === "date") {
      const isEmptyString = typeof value === 'string' && value.trim() === '';
      const isSelectAndEmpty = colDef.type === 'select' && (!value || value.trim() === '');

      if (isEmptyString || isSelectAndEmpty) {
        const msg = `El campo '${title}' es requerido`;
        toast.error(msg);

        if (typeof errorCallback === "function") {
          errorCallback({
            responseJSON: {
              errors: { validation: [msg] }
            }
          });
        }
        return false;
      }
    }

    if (colDef.typeof === "password") {
      const password = typeof value === 'string' ? value : '';

      if (password.trim() === '') {
        const msg = `El campo '${title}' no puede estar vacío`;
        toast.error(msg);

        if (typeof errorCallback === "function") {
          errorCallback({
            responseJSON: {
              errors: { validation: [msg] }
            }
          });
        }
        return false;
      }

      const isStrong = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/.test(password);

      if (!isStrong) {
        const msg = `El campo '${title}' debe tener al menos 8 caracteres, una mayúscula, una minúscula, un número y un símbolo.`;
        toast.error(msg);

        if (typeof errorCallback === "function") {
          errorCallback({
            responseJSON: {
              errors: { validation: [msg] }
            }
          });
        }
        return false;
      }
    }

    if (colDef.typeof === "email") {
      const allowedDomains = ['gmail.com', 'hotmail.com', 'outlook.com', 'icloud.com'];
      const email = typeof value === 'string' ? value.trim().toLowerCase() : '';

      const isValid = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
      const domain = email.split('@')[1];

      if (!isValid || !allowedDomains.includes(domain)) {
        const msg = `El campo '${title}' debe tener un correo válido de: ${allowedDomains.join(', ')}`;
        toast.error(msg);

        if (typeof errorCallback === "function") {
          errorCallback({
            responseJSON: {
              errors: { validation: [msg] }
            }
          });
        }
        return false;
      }
    }

    if (colDef.typeof === "decimal") {
      const isEmpty = value === '' || value === null;
      const isNotNumber = isNaN(parseFloat(value));
      if (isEmpty) {
        const msg = `El campo '${title}' es requerido y no puede estar vacío`;
        toast.error(msg);

        if (typeof errorCallback === "function") {
          errorCallback({
            responseJSON: {
              errors: { validation: [msg] }
            }
          });
        }
        return false;
      } else if (isNotNumber) {
        const msg = `El campo '${title}' debe ser un número válido`;
        toast.error(msg);

        if (typeof errorCallback === "function") {
          errorCallback({
            responseJSON: {
              errors: { validation: [msg] }
            }
          });
        }
        return false;
      }
    }
  }

  return true;
}
