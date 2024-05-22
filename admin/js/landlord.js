function paginateLandlords(totalPages, currentPage) {
    var paginationContainer = document.getElementById('paginationContainer');
    paginationContainer.innerHTML = '';

    var paginationList = document.createElement('ul');
    paginationList.classList.add('pagination');

    // Previous page button
    var prevPageItem = createPaginationItem(currentPage > 1 ? currentPage - 1 : 1, 'Previous', currentPage === 1 ? 'disabled' : '');
    paginationList.appendChild(prevPageItem);

    // Page buttons
    for (var i = 1; i <= totalPages; i++) {
        var pageItem = createPaginationItem(i, i, currentPage === i ? 'active' : '');
        paginationList.appendChild(pageItem);
    }

    // Next page button
    var nextPageItem = createPaginationItem(currentPage < totalPages ? currentPage + 1 : totalPages, 'Next', currentPage === totalPages ? 'disabled' : '');
    paginationList.appendChild(nextPageItem);

    paginationContainer.appendChild(paginationList);
}

function createPaginationItem(page, text, additionalClass) {
    var listItem = document.createElement('li');
    listItem.classList.add('page-item', additionalClass);

    var link = document.createElement('a');
    link.classList.add('page-link');
    link.href = '#';
    link.textContent = text;
    link.onclick = function () {
        changePage(page);
    };

    listItem.appendChild(link);
    return listItem;
}

function changePage(page) {
    // Update the page URL
    window.history.pushState({ page: page }, '', '?page=' + page);

    // Fetch landlords for the new page using AJAX or update the PHP code to handle the page parameter
    fetchLandlords(page);
}

function fetchLandlords(page) {
    var searchInput = document.getElementById('searchInput1').value;
    fetch('fetch_landlords.php?page=' + page + '&search=' + encodeURIComponent(searchInput))
        .then(response => response.json())
        .then(data => {
            updateLandlordCards(data.landlords);
            paginateLandlords(data.totalPages, page);
        })
        .catch(error => console.error('Error fetching landlords:', error));
}

function updateLandlordCards(landlords) {
    var landlordList = document.getElementById('landlordList');
    landlordList.innerHTML = '';

    landlords.forEach(landlord => {
        var landlordCard = `
            <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                <div class="card">
                    <img src="../${landlord.landlord_dp}" class="profile-img" alt="Landlord Profile" style="margin-top: 5%;">
                    <div class="card-body">
                        <h5 class="card-title text-center">${landlord.landlord_fname} ${landlord.landlord_lname}</h5>
                    </div>
                    <div class="card-footer">
                        <div class="row action-buttons">
                            <div class="col-md-6 text-center mt-2 mb-5">
                                <button class="btn btn-primary btn-sm mt-2 landlordreview-button mb-2" data-toggle="modal" data-target="#landlordReviewReportModal" data-landlord-data="${JSON.stringify(landlord)}">Landlord Details</button>
                                <a href="#" class="btn ban-button ml-2 mb-2" onclick="confirmBan(${landlord.landlord_id})">Ban</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;
        landlordList.insertAdjacentHTML('beforeend', landlordCard);
    });
}

// Initial load
fetchLandlords(1);