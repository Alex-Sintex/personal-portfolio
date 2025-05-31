let lFollowX = 0,
    lFollowY = 0,
    x = 0,
    y = 0,
    friction = 1 / 30;

function animate() {
    x += (lFollowX - x) * friction;
    y += (lFollowY - y) * friction;

    const translate = 'translate(' + x + 'px, ' + y + 'px) scale(1.1)';

    $('#image').css({
        '-webit-transform': translate,
        '-moz-transform': translate,
        'transform': translate
    });

    window.requestAnimationFrame(animate);
}

$(window).on('mousemove click', function (e) {

    const lMouseX = Math.max(-100, Math.min(100, $(window).width() / 2 - e.clientX));
    const lMouseY = Math.max(-100, Math.min(100, $(window).height() / 2 - e.clientY));
    lFollowX = (20 * lMouseX) / 100; // 100 : 12 = lMouxeX : lFollow
    lFollowY = (10 * lMouseY) / 100;

});

animate();