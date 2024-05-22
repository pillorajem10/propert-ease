function navigateToSection(pageUrl, sectionId) {
    // Construct the full URL with section ID
    var targetUrl = pageUrl + '#' + sectionId;

    // Navigate to the target URL
    window.location.href = targetUrl;
}