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

// Check decimal and empty fields
export function checkAllDecimalFields(data, columnDefs, errorCallback, toast) {
  for (let colDef of columnDefs) {
    if (colDef.typeof === "decimal") {

      // Skip validating 'SALDO KLAR' because it's auto-calculated in backend
      if (colDef.title === "SALDO KLAR") continue;

      const value = data[colDef.data];
      const title = colDef.title;

      const isEmpty = typeof value === 'string' && value.trim() === '';
      const isNotNumber = isNaN(parseFloat(value));

      if (isEmpty || isNotNumber) {
        const msg = `El campo numérico '${title}' no puede estar vacío ni contener texto no numérico.`;
        toast.error(msg);

        if (typeof errorCallback === "function") {
          errorCallback({
            responseJSON: {
              errors: {
                validation: [msg]
              }
            }
          });
        }
        return false;
      }
    }
  }
  return true;
}

export function parseNumber(value) {
  const num = parseFloat(String(value).replace(/,/g, '').trim());
  return isNaN(num) ? 0 : num;
}
