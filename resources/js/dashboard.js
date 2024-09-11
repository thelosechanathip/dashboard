document.querySelectorAll('.nav-link.dropdown-toggle').forEach(function (dropdown) {
    dropdown.addEventListener('click', function () {
        const targetId = this.getAttribute('data-bs-target');

        // ปิด dropdown ทุกตัวที่เปิดอยู่
        document.querySelectorAll('.collapse.show').forEach(function (openDropdown) {
            if (openDropdown.id !== targetId.substring(1)) {
                const icon = document.querySelector('[data-bs-target="#' + openDropdown.id + '"] .rotate-icon');
                if (icon) icon.classList.remove('rotated');
                openDropdown.classList.remove('show');
            }
        });

        // สลับการหมุนของไอคอนปัจจุบัน
        const icon = this.querySelector('.rotate-icon');
        if (icon) icon.classList.toggle('rotated');
    });

    // Reset icon when collapse is shown or hidden
    const collapseElement = document.querySelector(dropdown.dataset.bsTarget);
    collapseElement.addEventListener('hidden.bs.collapse', function () {
        const icon = dropdown.querySelector('.rotate-icon');
        if (icon) icon.classList.remove('rotated');
    });
    collapseElement.addEventListener('shown.bs.collapse', function () {
        const icon = dropdown.querySelector('.rotate-icon');
        if (icon) icon.classList.add('rotated');
    });
});

document.getElementById('sidebarToggle').addEventListener('click', function () {
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.querySelector('main');

    sidebar.classList.toggle('collapsed');

    if (window.innerWidth <= 500) {
        if (mainContent.style.display === 'none') {
            mainContent.style.display = 'block';
        } else {
            mainContent.style.display = 'none';
        }
    } else {
        // สำหรับหน้าจอที่กว้างกว่า 400px
        if (sidebar.classList.contains('collapsed')) {
            mainContent.classList.add('full-width');
        } else {
            mainContent.classList.remove('full-width');
        }
    }
});

// For handling the initial state on page load
document.addEventListener('DOMContentLoaded', function() {
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.querySelector('main');

    if (window.innerWidth <= 1400) {
        sidebar.classList.add('collapsed');
        mainContent.classList.add('full-width');
    }

    // Handle for initial load if the screen width is below 400px
    if (window.innerWidth <= 500) {
        mainContent.style.display = 'block';
    }
});

// For handling window resize event
window.addEventListener('resize', function() {
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.querySelector('main');

    if (window.innerWidth <= 1400) {
        sidebar.classList.add('collapsed');
        mainContent.classList.add('full-width');
    } else {
        sidebar.classList.remove('collapsed');
        mainContent.classList.remove('full-width');
    }

    // Handle visibility for screen width below 400px
    if (window.innerWidth > 500) {
        mainContent.style.display = 'block'; // Ensure main content is shown when resizing back to a larger screen
    }
});
