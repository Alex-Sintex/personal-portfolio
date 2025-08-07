document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.querySelector('.search-menu');
    const sidebar = document.querySelector('.sidebar-menu');

    searchInput.addEventListener('input', function () {
        const keyword = this.value.toLowerCase();
        const allLinks = sidebar.querySelectorAll('a');

        allLinks.forEach(link => {
            const text = link.textContent.trim().toLowerCase();
            const li = link.closest('li');
            const submenu = link.closest('.sidebar-submenu');
            const dropdown = link.closest('.sidebar-dropdown');

            if (keyword === '') {
                // Reset everything
                link.classList.remove('highlight');
                if (submenu) submenu.style.display = 'none';
                if (dropdown) dropdown.classList.remove('active');
            } else {
                if (text.includes(keyword)) {
                    link.classList.add('highlight');

                    // Ensure submenu is visible
                    if (submenu) {
                        submenu.style.display = 'block';
                        if (dropdown) dropdown.classList.add('active');
                    }

                    // For top-level items
                    if (dropdown && !submenu) {
                        dropdown.classList.add('active');
                    }
                } else {
                    link.classList.remove('highlight');
                }
            }
        });
    });
});
