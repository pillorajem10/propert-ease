function toggleSidebar() {
  const sidebar = document.getElementById("sidebar");
  const content = document.getElementById("content");
  const sidebarCollapse = document.getElementById("sidebarCollapse");
  const header = document.getElementById("header");
  const body = document.body;

  if (window.innerWidth > 767) {
    // Desktop version
    if (sidebar.style.width === "250px") {
      sidebar.style.width = "0";
      content.style.marginLeft = "0";
      sidebarCollapse.style.left = "20px";
      header.style.marginLeft = "0";
      body.classList.remove("sidebar-open");
    } else {
      sidebar.style.width = "250px";
      content.style.marginLeft = "250px";
      sidebarCollapse.style.left = "270px";
      header.style.marginLeft = "250px";
      body.classList.add("sidebar-open");
    }
  } else {
    // Mobile version
    if (sidebar.style.width === "100%") {
      sidebar.style.width = "0";
      content.style.marginLeft = "0";
      sidebarCollapse.style.left = "20px";
      header.style.marginLeft = "0";
      body.classList.remove("sidebar-open");
    } else {
      sidebar.style.width = "100%";
      content.style.marginLeft = "0";
      sidebarCollapse.style.left = "20px";
      header.style.marginLeft = "0";
      body.classList.add("sidebar-open");
    }
  }
}