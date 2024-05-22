$(document).ready(function() {
    // Find the maximum height among description elements
    var maxDescriptionHeight = 0;
    $('.property-description').each(function() {
        var height = $(this).height();
        if (height > maxDescriptionHeight) {
            maxDescriptionHeight = height;
        }
    });
    // Set the height of all description elements to the maximum height
    $('.property-description').height(maxDescriptionHeight);
});