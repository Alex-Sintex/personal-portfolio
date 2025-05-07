// Checked List
$(document).ready(function () {

  // Declare checkedItems outside the $(document).ready() function
  var checkedItems = [];

  // Function to update the checked items in local storage
  function updateCheckedItems() {
    localStorage.setItem('checkedItems', JSON.stringify(checkedItems));
  }

  // Set unique IDs for each list item
  $(".todo-list li").each(function (index) {
    $(this).attr("id", "item" + (index + 1));
  });

  // Initialize the sortable list
  $(".todo-list").sortable({
    placeholder: "sort-highlight",
    handle: ".handle",
    forcePlaceholderSize: true,
    zIndex: 999999,
    update: function (event, ui) {
      // Get the updated order of items
      var updatedOrder = $(this).sortable('toArray');

      // Store the updated order in local storage
      //localStorage.setItem('todoOrder', JSON.stringify(updatedOrder));
    }
  });

  // Load the order from local storage and apply it
  var storedOrder = localStorage.getItem('todoOrder');
  if (storedOrder) {
    storedOrder = JSON.parse(storedOrder);
    $.each(storedOrder, function (index, value) {
      $('#' + value).appendTo('.todo-list');
    });
  }

  // Load checked items from local storage
  var storedCheckedItems = localStorage.getItem('checkedItems');
  if (storedCheckedItems) {
    checkedItems = JSON.parse(storedCheckedItems);

    // Check the items that were previously checked and add the "done" class
    $.each(checkedItems, function (index, value) {
      var itemElement = $('#' + value);
      itemElement.find('input[type="checkbox"]').prop('checked', true);
      itemElement.addClass('done');
    });
  }

  // Initialize the todoList component
  $(".todo-list").todoList({
    onCheck: function () {
      var itemId = $(this).closest("li").attr("id");
      checkedItems.push(itemId);
      updateCheckedItems();

      // Add the "done" class when an item is checked
      $(this).closest("li").addClass('done');

      //console.log("The element with ID " + itemId + " has been checked");
    },
    onUnCheck: function () {
      var itemId = $(this).closest("li").attr("id");
      // Remove the item from the checkedItems array
      checkedItems = checkedItems.filter(item => item !== itemId);
      updateCheckedItems();

      // Remove the "done" class when an item is unchecked
      $(this).closest("li").removeClass('done');

      //console.log("The element with ID " + itemId + " has been unchecked");
    },
  });
});