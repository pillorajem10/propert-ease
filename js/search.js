document.addEventListener("DOMContentLoaded", function () {
  const searchIcon = document.querySelector(".search-icon");
  searchIcon.addEventListener("click", function () {
    this.classList.add("clicked");
    setTimeout(() => {
      searchIcon.classList.remove("clicked");
    }, 300);
  });
});