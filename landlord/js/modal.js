document.addEventListener("DOMContentLoaded", function () {
  const editProfileBtn = document.getElementById("editProfileBtn");
  const editProfileSection = document.getElementById("editProfileSection");
  const cancelEditBtn = document.getElementById("cancelEditBtn");

  editProfileBtn.addEventListener("click", function () {
    editProfileSection.style.display = "block"; // Show the edit section
  });

  cancelEditBtn.addEventListener("click", function () {
    editProfileSection.style.display = "none"; // Hide the edit section
  });
});