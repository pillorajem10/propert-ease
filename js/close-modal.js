$(document).ready(function() {
    // Close modal function
    $(".close-modal").click(function() {
        $("#editProfileSection").modal("hide");
    });

    // Trigger cancel button click on modal hide
    $("#editProfileSection").on("hidden.bs.modal", function() {
        $(".close-modal").click();
    });
});