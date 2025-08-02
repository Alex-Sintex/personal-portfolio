$(document).ready(function () {
    /* JS AWESOME ARROW */
    const $icon1 = document.querySelector(".icon1");
    const $icon2 = document.querySelector(".icon2");
    const $arrow1 = document.querySelector(".arrow-left");
    const $arrow2 = document.querySelector(".arrow-right");

    $icon1.addEventListener("mouseenter", () => {
        $arrow1.animate([{ left: "0" }, { left: "10px" }, { left: "0" }], {
            duration: 700,
            iterations: Infinity
        });
    });

    $icon1.addEventListener("mouseleave", () => {
        $arrow1.style.left = "0"; // Reset left position on mouse leave
        $arrow1.getAnimations().forEach(animation => animation.cancel());
    });

    $icon2.addEventListener("mouseenter", () => {
        $arrow2.animate([{ left: "0" }, { left: "10px" }, { left: "0" }], {
            duration: 700,
            iterations: Infinity
        });
    });

    $icon2.addEventListener("mouseleave", () => {
        $arrow2.style.left = "0"; // Reset left position on mouse leave
        $arrow2.getAnimations().forEach(animation => animation.cancel());
    });

    // Use event delegation for dynamic elements
    $(document).on("click", "#next-btn", function () {
        showNextDiv();
    });

    $(document).on("click", "#prev-btn", function () {
        showPrevDiv();
    });

    $(document).on("click", ".map-point-sm", function () {
        var show = $(this).data("show");
        showDiv(show);
    });

    // Handle left and right arrow key presses
    $(document).keydown(function (e) {
        if (e.which === 37) {
            // Left arrow key
            showPrevDiv();
        } else if (e.which === 39) {
            // Right arrow key
            showNextDiv();
        }
    });

    var currentDiv = 0;
    var totalDivs = $(".division-details > div").length;

    function showNextDiv() {
        $(".division-details > div.page" + (currentDiv + 1)).addClass("hide");
        currentDiv = (currentDiv + 1) % totalDivs;
        $(".division-details > div.page" + (currentDiv + 1)).removeClass("hide");
    }

    function showPrevDiv() {
        $(".division-details > div.page" + (currentDiv + 1)).addClass("hide");
        currentDiv = (currentDiv - 1 + totalDivs) % totalDivs;
        $(".division-details > div.page" + (currentDiv + 1)).removeClass("hide");
    }

    function showDiv(show) {
        currentDiv = $(".division-details > div[class^='page']").index($(show));
        $(".division-details > div[class^='page']").addClass("hide");
        $(".division-details > div.page" + (currentDiv + 1)).removeClass("hide");
    }
});