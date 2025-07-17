/**
 * Format a number as currency (USD).
 * @param {number|string} data
 * @param {string} type
 * @returns {string|number}
 */
export function currencyRender(data, type) {
  if ((type === 'display' || type === 'filter') && !isNaN(data)) {
    return parseFloat(data).toLocaleString('en-US', {
      style: 'currency',
      currency: 'USD',
    });
  }
  return data;
}

/**
 * Format phone numbers as (XXX) XXX-XXXX
 * @param {string|number} data
 * @param {string} type
 * @returns {string}
 */
export function phoneRender(data, type) {
  if ((type === 'display' || type === 'filter') && data) {
    const digits = String(data).replace(/\D/g, '').slice(0, 10);
    if (digits.length === 10) {
      return `(${digits.slice(0, 3)}) ${digits.slice(3, 6)}-${digits.slice(6)}`;
    }
    return digits;
  }
  return data;
}

/**
 * Format phone input as user types (input mask behavior).
 * @param {HTMLInputElement} input
 */
export function formatPhoneOnInput(input) {
  input.addEventListener('input', function () {
    let digits = this.value.replace(/\D/g, '').slice(0, 10);
    if (digits.length >= 6) {
      this.value = `(${digits.slice(0, 3)}) ${digits.slice(3, 6)}-${digits.slice(6)}`;
    } else if (digits.length >= 3) {
      this.value = `(${digits.slice(0, 3)}) ${digits.slice(3)}`;
    } else {
      this.value = digits;
    }
  });
}

/**
 * Validate fields marked as required in columnDefs.
 * Checks for empty values, valid email, strong password, etc.
 * 
 * @param {object} data - Submitted row data
 * @param {array} columnDefs - DataTable columnDefs
 * @param {function} errorCallback - Function to call on error
 * @param {object} toast - Toasty instance for displaying errors
 * @returns {boolean}
 */
export function checkRequiredFields(data, columnDefs, errorCallback, toast) {
  for (let colDef of columnDefs) {
    if (!colDef.required) continue;

    const value = data[colDef.data];
    const title = colDef.title;

    // Check for empty fields
    const isEmpty =
      value === null ||
      value === undefined ||
      (typeof value === 'string' && value.trim() === '');

    if (colDef.typeof === 'string' || colDef.typeof === 'date') {
      if (isEmpty) return handleError(`${title} es requerido`);
    }

    if (colDef.typeof === 'password') {
      if (isEmpty) return handleError(`${title} no puede estar vacío`);

      const strong = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/.test(value);
      if (!strong) {
        return handleError(
          `${title} debe tener al menos 8 caracteres, una mayúscula, una minúscula, un número y un símbolo.`
        );
      }
    }

    if (colDef.typeof === 'email') {
      const allowedDomains = ['gmail.com', 'hotmail.com', 'outlook.com', 'icloud.com'];
      const email = value?.trim().toLowerCase() || '';
      const domain = email.split('@')[1];

      const valid = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email) &&
        allowedDomains.includes(domain);

      if (!valid) {
        return handleError(`${title} debe tener un correo válido de: ${allowedDomains.join(', ')}`);
      }
    }

    if (colDef.typeof === 'decimal') {
      if (isEmpty) return handleError(`${title} no puede estar vacío`);
      if (isNaN(parseFloat(value))) return handleError(`${title} debe ser un número válido`);
    }

    if (colDef.typeof === 'phone') {
      const digits = typeof value === 'string' ? value.replace(/\D/g, '') : '';
      if (digits.length !== 10) {
        return handleError(`${title} debe contener un número de teléfono válido de 10 dígitos`);
      }
    }
  }

  return true;

  // Helper for error reporting
  function handleError(msg) {
    toast.error(msg);
    if (typeof errorCallback === 'function') {
      errorCallback({
        responseJSON: {
          errors: { validation: [msg] },
        },
      });
    }
    return false;
  }
}