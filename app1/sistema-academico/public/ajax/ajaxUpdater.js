function updateTable() {
    $.ajax({
        type: 'GET',
        url: 'fetchFDCData', // Fetches new data
        dataType: 'json', // Server response
        success: function (response) {

            // Loop through the response and update the corresponding cells
            $.each(response, function (index, fdc) {
                var rowId = '#example1 tbody tr[data-id="' + fdc.nControl + '"]';

                // Find the row based on the data-id attribute
                var existingRow = $(rowId);

                // If the row exists, update its cells
                if (existingRow.length !== 0) {

                    var imageCell = existingRow.find('td img');

                    // Check if the URL has changed
                    if (imageCell.attr('src') !== fdc.firma_alumno) {
                        imageCell.attr('src', fdc.firma_alumno);
                    }

                    existingRow.find('td.specific-nControl').text(fdc.nControl);
                    existingRow.find('td.specific-name').text(fdc.nombre);
                    existingRow.find('td.specific-aPaterno').text(fdc.aPaterno);
                    existingRow.find('td.specific-aMaterno').text(fdc.aMaterno);
                    existingRow.find('td.specific-carrera').text(fdc.carrera);
                    existingRow.find('td.specific-asunto').text(fdc.asunto);
                    existingRow.find('td.specific-peticion').text(fdc.peticion);
                    existingRow.find('td.specific-fecha').text(fdc.fecha);

                    // Check if existing row motivos académicos is null or empty
                    var motivosACell = existingRow.find('td.specific-motivosA');
                    motivosACell.text(fdc.motivosA === "" ? "Ninguno" : fdc.motivosA);

                    // Check if existing row motivos personales is null or empty
                    var motivosPCell = existingRow.find('td.specific-motivosP');
                    motivosPCell.text(fdc.motivosP === "" ? "Ninguno" : fdc.motivosP);

                    // Check if existing row otros motivos is null or empty
                    var otrosMCell = existingRow.find('td.specific-otrosM');
                    otrosMCell.text(fdc.otrosM === "" ? "No aplica" : fdc.otrosM);

                    // Check if existing row anexos is null or empty
                    var anexosCell = existingRow.find('td.specific-anexos');
                    anexosCell.text(fdc.anexos !== null ? "Ninguno" : fdc.anexos);

                    existingRow.find('td.specific-telefono').text(fdc.telefono);
                    existingRow.find('td.specific-correo').text(fdc.correo);
                } else {
                    // Row doesn't exist, append a new row to the table
                    var newRow = '<tr data-id="' + fdc.nControl + '">'
                        + '<td><img src="' + fdc.firma_alumno + '" alt="User Image"></td>'
                        + '<td class="specific-nControl">' + fdc.nControl + '</td>'
                        + '<td class="specific-name">' + fdc.nombre + '</td>'
                        + '<td class="specific-aPaterno">' + fdc.aPaterno + '</td>'
                        + '<td class="specific-aMaterno">' + fdc.aMaterno + '</td>'
                        + '<td class="specific-carrera">' + fdc.carrera + '</td>'
                        + '<td class="specific-asunto">' + fdc.asunto + '</td>'
                        + '<td class="specific-peticion">' + fdc.peticion + '</td>'
                        + '<td class="specific-fecha">' + fdc.fecha + '</td>'
                        + '<td class="specific-motivosA">' + (fdc.motivosA === "" ? "Ninguno" : fdc.motivosA) + '</td>'
                        + '<td class="specific-motivosP">' + (fdc.motivosP === "" ? "Ninguno" : fdc.motivosP) + '</td>'
                        + '<td class="specific-otrosM">' + (fdc.otrosM === "" ? "No aplica" : fdc.otrosM) + '</td>'
                        + '<td class="specific-anexos">' + (fdc.anexos === null ? "Ninguno" : fdc.anexos) + '</td>'
                        + '<td class="specific-telefono">' + fdc.telefono + '</td>'
                        + '<td class="specific-correo">' + fdc.correo + '</td>'
                        + '</tr>';

                    // Append the new row to the table body
                    $('#example1 tbody').append(newRow);
                }
            });
        },
        error: function (xhr, status, error) {
            console.error('Error fetching data:', xhr.responseText);
        },
        complete: function () {
            setTimeout(updateTable, 5000);
        }
    });
}

// Call the function initially
updateTable();