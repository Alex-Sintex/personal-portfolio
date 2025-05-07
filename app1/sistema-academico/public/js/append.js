$(document).ready(function () {
    // Function to fit textarea
    var textareas = document.querySelectorAll(".field");

    // Set initial size limits
    var minWidth = 300;
    var minHeight = 35;
    var maxWidth = 300;
    var maxHeight = 300;

    // Function to update textarea size
    function updateSize(textarea) {
        // Calculate new width based on content, respecting min-width
        textarea.style.width = 'auto';
        var newWidth = Math.max(Math.min(textarea.scrollWidth, maxWidth), minWidth);
        textarea.style.width = newWidth + 'px';

        // Calculate new height based on content, respecting min-height
        textarea.style.height = 'auto';
        var newHeight = Math.max(
            Math.min(textarea.scrollHeight, maxHeight),
            parseInt(window.getComputedStyle(textarea).getPropertyValue('min-height')),
            minHeight
        );
        textarea.style.height = newHeight + 'px';
    }

    // Event listener to adjust size on user input for each textarea
    textareas.forEach(function (textarea) {
        textarea.addEventListener('input', function () {
            updateSize(textarea);
        });
        // Call the function initially to set the size based on any default content
        updateSize(textarea);
    });
    /***************************/

    var buttonAdd = $("#add-button");
    var buttonRemove = $("#remove-button");
    var className = ".dynamic-field";
    var count = 0;
    var field = "";
    var maxFields = 50;

    function totalFields() {
        return $(className).length;
    }

    function addNewField() {
        count = totalFields() + 1;
        field = $("#dynamic-field-1").clone();
        field.attr("id", "dynamic-field-" + count);
        field.children("label").text("Field " + count);
        field.find("input").val("");
        $(className + ":last").after($(field));
    }

    function removeLastField() {
        if (totalFields() > 1) {
            $(className + ":last").remove();
        }
    }

    function enableButtonRemove() {
        if (totalFields() === 2) {
            buttonRemove.removeAttr("disabled");
            buttonRemove.addClass("shadow-sm");
        }
    }

    function disableButtonRemove() {
        if (totalFields() === 1) {
            buttonRemove.attr("disabled", "disabled");
            buttonRemove.removeClass("shadow-sm");
        }
    }

    function disableButtonAdd() {
        if (totalFields() === maxFields) {
            buttonAdd.attr("disabled", "disabled");
            buttonAdd.removeClass("shadow-sm");
        }
    }

    function enableButtonAdd() {
        if (totalFields() === maxFields - 1) {
            buttonAdd.removeAttr("disabled");
            buttonAdd.addClass("shadow-sm");
        }
    }

    buttonAdd.click(function () {
        addNewField();
        enableButtonRemove();
        disableButtonAdd();
    });

    buttonRemove.click(function () {
        removeLastField();
        disableButtonRemove();
        enableButtonAdd();
    });

    /* GENERAL SUBJECT APPENDING */
    // Initial counter value
    let counter = 1;

    // Initially, hide the delete button
    $(".delete").prop("disabled", true);

    $("#add").click(function (e) {
        // Show the delete button when a new div is added
        $(".delete").prop("disabled", false);

        // Append a new row of code to the "#items" div with the incremented counter value
        $("#items").append(
            `<div class="col-md-4 margin-bottom">
            <h4>AG${counter}</h4>
            <textarea id="resolucionAG" name="resolucionAG" class="form-control field" cols="40" autocomplete="off" role="textbox" aria-autocomplete="list" aria-haspopup="true" placeholder="Se analiza la solicitud mediante..." style="width: 100%;"></textarea>
            <input id="nomAlumAG" name="nomAlumAG" type="text" placeholder="Nombre del alumno" class="form-control input-md">
            <input id="nCtrlAlumAG" name="nCtrlAlumAG" type="text" placeholder="No. Control del alumno" class="form-control input-md">
            <select id="careerSelAG" class="select" style="width: 100%;"><i class="fa fa-angle-left pull-right"></i>
                <option value="" disabled selected>Selecciona una carrera</option>
                <option value="Ingeniería Industrial">Ingeniería Industrial</option>
                <option value="Ingeniería en Gestión Empresarial">Ingeniería en Gestión Empresarial</option>
                <option value="Ingeniería en Sistemas Computacionales">Ingeniería en Sistemas Computacionales</option>
                <option value="Ingeniería en Electrónica">Ingeniería en Electrónica</option>
                <option value="Ingeniería Electromecánica">Ingeniería Electromecánica</option>
                <option value="Ingeniería en Industrias Alimentarias">Ingeniería en Industrias Alimentarias</option>
                <option value="Ingeniería Bioquímica">Ingeniería Bioquímica</option>
                <option value="Ingeniería Mecatrónica">Ingeniería Mecatrónica</option>
                <option value="Ingeniería Civil">Ingeniería Civil</option>
                <option value="Licenciatura en Gastronomía">Licenciatura en Gastronomía</option>
            </select>
            <input id="responsableAG" name="responsableAG" type="text" placeholder="Enviado por el Ing...." class="form-control input-md">
        </div>`
        );

        // Increment the counter for the next iteration
        counter++;
    });

    $("body").on("click", ".delete", function (e) {
        // Remove the last .col-md-4 margin-bottom div
        $(".col-md-4.margin-bottom").last().remove();

        // Decrement the counter to maintain the correct value for the next iteration
        counter--;

        // If there are no more divs, disable the delete button
        if (counter === 1) {
            $(".delete").prop("disabled", true);
        }
    });

    // Ensure counter is initialized to 1 when the document is ready
    $(document).ready(function () {
        counter = 1;
    });
});