document.addEventListener('DOMContentLoaded', () => {
    const openBgSelectorBtn = document.getElementById('openBackgroundSelector');
    const backgroundSelectorModal = new bootstrap.Modal(document.getElementById('backgroundSelectorModal'));
    const bgContainer = document.getElementById('bg');
    const bgOptions = document.querySelectorAll('.background-thumb');

    // Load saved background from localStorage on page load
    const savedBg = localStorage.getItem('chatBackground');
    if (savedBg) {
        bgContainer.style.backgroundImage = `url(${savedBg})`;
        bgContainer.style.backgroundSize = 'cover';
        bgContainer.style.backgroundPosition = 'center';
        bgContainer.style.backgroundRepeat = 'no-repeat';
    }

    // Open modal when clicking the menu item
    if (openBgSelectorBtn) {
        openBgSelectorBtn.addEventListener('click', (e) => {
            e.preventDefault();
            backgroundSelectorModal.show();
        });
    }

    // Change background when image is selected
    bgOptions.forEach(img => {
        img.addEventListener('click', () => {
            const imageUrl = img.src;

            // Apply image as background
            bgContainer.style.backgroundImage = `url(${imageUrl})`;
            bgContainer.style.backgroundSize = 'cover';
            bgContainer.style.backgroundPosition = 'center';
            bgContainer.style.backgroundRepeat = 'no-repeat';

            // Save to localStorage
            localStorage.setItem('chatBackground', imageUrl);

            // Close modal
            backgroundSelectorModal.hide();
        });
    });

    const resetBtn = document.getElementById('resetBackground');
    if (resetBtn) {
        resetBtn.addEventListener('click', () => {
            bgContainer.style.backgroundImage = 'none';
            localStorage.removeItem('chatBackground');
            backgroundSelectorModal.hide();
        });
    }

    bgContainer.addEventListener('scroll', () => {
        const scrollTop = bgContainer.scrollTop;
        const scrollHeight = bgContainer.scrollHeight - bgContainer.clientHeight;

        const scrollPercent = scrollTop / scrollHeight;

        // Calculate vertical background position
        const bgPositionY = scrollPercent * 100;

        // Set background position dynamically
        bgContainer.style.backgroundPosition = `center ${bgPositionY}%`;
    });
});
