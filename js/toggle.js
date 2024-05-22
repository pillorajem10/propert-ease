$(document).ready(function() {
    // Toggle the collapse state when clicking the button
    $('.card-header button').click(function() {
        // Get the target collapse element
        var target = $($(this).data('target'));
        // Toggle its collapse state
        target.collapse('toggle');
    });
});