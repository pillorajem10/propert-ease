$(document).ready(function() {
    $("#booking_date").datepicker({
        dateFormat: 'yy-mm-dd',
        minDate: 0,
    });

    $("#scheduleBtn").on("click", function() {
        var selectedDate = $("#booking_date").val();
        if (selectedDate !== '') {
            $("#selected_date").val(selectedDate);
            $("#bookingForm").submit();
        } else {
            alert("Please select a booking date.");
        }
    });
});