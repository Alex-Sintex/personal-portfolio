$(document).ready(function () {
    // Attach event handler to the keyup event for real-time search
    $("input[name='q']").keyup(function () {
        // Get the search query from the input field
        var searchQuery = $(this).val().toLowerCase();

        // Check if the search query is empty
        if (searchQuery === "") {
            // Show the default elements and remove any search-related modifications
            $(".treeview").show().removeClass("active menu-open");
            $(".treeview i").show();
            return; // Exit the function early when the search query is empty
        }

        // Loop through each tree-view menu
        $(".treeview").each(function () {
            var menuText = $(this).text().toLowerCase();
            var iconElement = $(this).find("i"); // Get the icon element

            // Check if the menu contains the search query
            if (menuText.includes(searchQuery)) {
                // Show the menu, the icon, and add the 'active' class
                $(this).show();
                iconElement.show();
                $(this).addClass("active");

                // Check if the menu has a nested treeview-menu
                var nestedMenu = $(this).find(".treeview-menu");
                if (nestedMenu.length > 0) {
                    // Add the 'menu-open' class to expand the nested menu
                    $(this).addClass("menu-open");
                }
            } else {
                // Hide the menu and the icon, remove the 'active' and 'menu-open' classes
                $(this).hide();
                iconElement.hide();
                $(this).removeClass("active");
                $(this).removeClass("menu-open");
            }
        });
    });
});