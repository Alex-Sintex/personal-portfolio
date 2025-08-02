// Listen to the change event on elements with the class "image-picker"
$(".image-picker").change(function (event) {
  var userId = $(this).data("user-id");
  console.log("User ID:", userId); // Log user ID
  readURL(this, userId);
});

function readURL(input, userId) {
  if (input.files && input.files[0]) {
      console.log("File selected:", input.files[0].name); // Log the selected file name
      var reader = new FileReader();

      reader.onload = function (e) {
          console.log("File loaded:", e.target.result); // Log the loaded file data
          $('#image-preview' + userId).attr('src', e.target.result);
          $('#image-name' + userId).text(input.files[0].name);
      }

      reader.readAsDataURL(input.files[0]);
  }
}
