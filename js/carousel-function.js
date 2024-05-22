// Enable drag behavior for carousel items
$('#propertyCarousel').on('mousedown touchstart', '.carousel-item', function (e) {
    var startX = e.type === 'mousedown' ? e.pageX : e.originalEvent.touches[0].pageX;
    $(this).data('down', true).data('startX', startX);
});

$('#propertyCarousel').on('mouseup touchend', '.carousel-item', function (e) {
    if ($(this).data('down')) {
        var endX = e.type === 'mouseup' ? e.pageX : e.originalEvent.changedTouches[0].pageX;
        var startX = $(this).data('startX');
        if (Math.abs(endX - startX) > 50) {
            $(this).carousel(endX > startX ? 'prev' : 'next');
        }
        $(this).data('down', false);
    }
});

$(document).ready(function () {
    // Adjust carousel display based on screen width
    function adjustCarouselDisplay() {
        if ($(window).width() < 768) {
            // Mobile view - display one property per slide
            $('#propertyCarousel .carousel-inner .carousel-item .row.ltn__product-slider').removeClass('justify-content-center');
        } else {
            // Desktop view - display two properties per slide
            $('#propertyCarousel .carousel-inner .carousel-item .row.ltn__product-slider').addClass('justify-content-center');
        }
    }

    // Call adjustCarouselDisplay on page load and window resize
    adjustCarouselDisplay();
    $(window).resize(adjustCarouselDisplay);
});