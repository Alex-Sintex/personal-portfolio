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
      const value = data[colDef.data];
      const title = colDef.title;

      const isEmpty = typeof value === 'string' && value.trim() === '';
      const isNotNumber = isNaN(parseFloat(value));

      if (isEmpty || isNotNumber) {
        const msg = `El campo numérico '${title}' no puede estar vacío ni contener texto no numérico.`;
        toast.error(msg);

        // Call altEditor error callback to trigger modal error
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

// Other calculations for balance module
export function calculateVentaTarjeta(row) {
  return parseNumber(row.ventNetTar) * 0.9651;
}

export function calculateTotalIngresos(row, ventaTarjeta) {
  return parseNumber(row.ventTransf) + ventaTarjeta + parseNumber(row.ventEfect);
}

export function calculateUtilidadPiso(totalIngresos, row) {
  return totalIngresos + parseNumber(row.depPlatf);
}

export function calculateUtilidadNetaPlataforma(row) {
  return (parseNumber(row.ub) + parseNumber(row.did) + parseNumber(row.rap)) / 2;
}

export function calculateTotalEgresos(row, gastosDiarios) {
  return parseNumber(row.totGF) + gastosDiarios;
}

export function calculateTotalPlataformas(row) {
  return parseNumber(row.ub) + parseNumber(row.did) + parseNumber(row.rap);
}

export function calculateUtilidadDisponible(utilidadPiso, utilidadAnterior, row, gastosDiarios) {
  return (utilidadPiso + utilidadAnterior) - (parseNumber(row.reparUtil) + parseNumber(row.totGF) + gastosDiarios);
}

export function calculateUtilidadNeta(utilidadPiso, utilidadNetPlataforma, totalEgresos) {
  return (utilidadPiso + utilidadNetPlataforma) - totalEgresos;
}

export function updateCalTbl() {
  const data = inTbl.rows().data().toArray();
  calTbl.clear();

  let utilidadAnterior = 0;
  let gastosDiarios = 3439.50;

  data.forEach((row) => {
    const ventaTarjeta = calculateVentaTarjeta(row);
    const totalIngresos = calculateTotalIngresos(row, ventaTarjeta);
    const utilidadPiso = calculateUtilidadPiso(totalIngresos, row);
    const totalEgresos = calculateTotalEgresos(row, gastosDiarios);
    const utilidadPlataforma = calculateUtilidadNetaPlataforma(row);

    const utilidadNeta = calculateUtilidadNeta(utilidadPiso, utilidadPlataforma, totalEgresos);
    const efectivoCierre = parseNumber(row.ventEfect) - parseNumber(row.gastEfect);
    const utilidadDisponible = calculateUtilidadDisponible(utilidadPiso, utilidadAnterior, row, gastosDiarios);
    const totalPlataformas = calculateTotalPlataformas(row);

    calTbl.row.add({
      utilidadNeta: utilidadNeta.toFixed(2),
      totalEgresos: totalEgresos.toFixed(2),
      efectivoCierre: efectivoCierre.toFixed(2),
      ventaTarjeta: ventaTarjeta.toFixed(2),
      totalIngresos: totalIngresos.toFixed(2),
      utilidadPiso: utilidadPiso.toFixed(2),
      utilidadDisponible: utilidadDisponible.toFixed(2),
      total: totalPlataformas.toFixed(2),
      utilidadPlataforma: utilidadPlataforma.toFixed(2)
    });

    utilidadAnterior = utilidadDisponible;
  });

  calTbl.draw();
}