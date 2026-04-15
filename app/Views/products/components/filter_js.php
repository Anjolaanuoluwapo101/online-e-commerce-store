<script>
    function changePage(page, tb) {
        var searchlink = "/products/" + tb + "?page=" + page;
        window.location.href = searchlink;
    }

    function searchItem(page, item = "", marker = 0) {
        var searchItem = document.getElementById("searchInput").value;
        if (marker != 0) {
            item = searchItem;
        }
        
        if (item == "" || item == "all") {
            window.location.href = "/products?page=" + page;
        } else {
            var searchlink = "/products/search?item=" + encodeURIComponent(item) + "&page=" + page;
            window.location.href = searchlink;
        }
    }
    
    function handlePagination(page) {
        // Prevent default behavior and scroll smoothly to top
        $('html, body').animate({ scrollTop: 0 }, 500);
        changePage(page, 'all');
    }
    
    // Reset filters functionality
    document.addEventListener('DOMContentLoaded', function() {
        var resetBtn = document.getElementById('resetFilters');
        if (resetBtn) {
            resetBtn.addEventListener('click', function() {
                window.location.href = "/products";
            });
        }
    });
    
    // Close dropdown when clicking outside
    document.addEventListener('click', function(event) {
        var dropdown = document.getElementById('filterDropdown');
        if (dropdown) {
            var dropdownMenu = dropdown.nextElementSibling;
            if (!dropdown.contains(event.target) && !dropdownMenu.contains(event.target)) {
                var bsDropdown = bootstrap.Dropdown.getInstance(dropdown);
                if (bsDropdown) {
                    bsDropdown.hide();
                }
            }
        }
    });
</script>