$(function () {
  "use strict";

  $(".connectedSortable").sortable({
    containment: $("section.content"),
    placeholder: "sort-highlight",
    connectWith: ".connectedSortable",
    handle: ".box-header, .nav-tabs",
    forcePlaceholderSize: true,
    zIndex: 999999,
  });

  $(".connectedSortable .box-header, .connectedSortable .nav-tabs-custom").css(
    "cursor",
    "move",
  );
});