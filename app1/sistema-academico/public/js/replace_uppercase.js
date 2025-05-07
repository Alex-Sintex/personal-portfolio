$(document).ready(function () {
    // Add an event listener to the input field
    document.getElementById("nControl_stud").addEventListener("blur", function () {
        // Get the current value of the input field
        var nControl_stud = this.value;
        // Replace all occurrences of 'o' with 'O'
        nControl_stud = nControl_stud.replace(/o/g, 'O');
        // Update the input field with the modified value
        this.value = nControl_stud;
    });
});