$(document).ready(function () {
  var currentStep = 1;

  // Function to show current step and update progress bar
  function showStep(step) {
    $(".form-step").hide(); // Hide all steps
    $("#step" + step).show(); // Show current step
    $(".progress-step").removeClass("progress-step-active"); // Remove active class from all progress steps
    $(".progress-step")
      .eq(step - 1)
      .addClass("progress-step-active"); // Add active class to current progress step
    $("#progress .progress-bar").css("width", (step - 1) * 33.33 + "%"); // Update progress bar width

    // Check if it's a previous or next step
    if (step < currentStep) {
      // Previous step: Set margin top to 20%
      $(".form-step").css("margin-top", "20%");
    } else {
      // Next step: Maintain margin top at 20%
      $(".form-step").css("margin-top", "20%");
    }
  }

  // Initialize page: Show initial step and hide progress bar
  showStep(currentStep);
  $(".progressbar").hide();

  // Next button click handler
  $(".btn-next").click(function (e) {
    e.preventDefault();
    if (currentStep < 4) {
      // Check if it's not the last step
      currentStep++; // Increment current step
      showStep(currentStep); // Show next step
      $(".progressbar").show(); // Show progress bar
    }
  });

  // Previous button click handler
  $(".btn-prev").click(function (e) {
    e.preventDefault();
    if (currentStep > 1) {
      // Check if it's not the first step
      currentStep--; // Decrement current step
      showStep(currentStep); // Show previous step
      $(".progressbar").show(); // Show progress bar
    }
  });
});