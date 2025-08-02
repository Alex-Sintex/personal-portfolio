onEditRow = function (dt, rowdata, success, error) {
    const rowIndex = dt.row({ selected: true }).index(); // Get selected row index
    const updatedRow = dt.row(rowIndex).data(); // Get updated row data (in-memory)

    console.log("Saving selected row:", updatedRow);

    $.ajax({
        url: '/your-server-endpoint', // Change this URL to your backend
        method: 'POST',
        contentType: 'application/json',
        data: JSON.stringify(updatedRow),
        success: function (response) {
            success(response); // Notify altEditor it was successful
            toast.success("Fila actualizada en la base de datos");
        },
        error: function (xhr, status, err) {
            error(xhr.responseText); // Notify altEditor of the error
            toast.error("Error al guardar en la base de datos");
        }
    });
};

// ✅ Make regular table cells editable
$('#tableGD tbody').on('click', 'td', function () {
    const cell = tbl.cell(this);
    const colIdx = cell.index()?.column;

    if (!colIdx || tbl.column(colIdx).visible() === false) return;
    const original = cell.data();

    // Prevent editing actions column or index column (if any)
    if ($(this).hasClass('dt-control') || colIdx === 0) return;

    const $input = $('<input type="text" class="form-control form-control-sm" />')
        .val(original);

    $(this).html($input);
    $input.focus();

    $input.on('blur keyup', function (e) {
        if (e.type === 'blur' || e.key === 'Enter') {
            const newVal = $(this).val().trim();
            cell.data(newVal).draw();

            const rowData = tbl.row(cell.index().row).data();
            const colName = tbl.column(colIdx).header().innerText;
            console.log(`Updated main cell: ${colName} = ${newVal}`, rowData);
        }
    });
});


// ✅ Make <span class="dtr-data"> inside child rows editable
$('#tableGD tbody').on('click', 'span.dtr-data', function () {
    const $span = $(this);
    const originalValue = $span.text().trim();

    // Prevent multiple inputs
    if ($span.find('input').length > 0) return;

    const $input = $('<input type="text" class="form-control form-control-sm" />')
        .val(originalValue);

    $span.empty().append($input);
    $input.focus();

    $input.on('blur keyup', function (e) {
        if (e.type === 'blur' || e.key === 'Enter') {
            const newValue = $(this).val().trim();
            $span.text(newValue);

            // 🔁 Save into DataTables row data object (in memory)
            const $mainRow = $span.closest('tr').prev();
            const row = tbl.row($mainRow).data();

            const field = $span.closest('li').find('.dtr-title').text()
                .toLowerCase().replace(/\s+/g, '_'); // Normalize field name

            row[field] = newValue;
            console.log(`Updated child field: ${field} = ${newValue}`, row);
        }
    });
});