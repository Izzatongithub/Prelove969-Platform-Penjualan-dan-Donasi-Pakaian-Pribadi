document.addEventListener('DOMContentLoaded', function() {
    const navItems = document.querySelectorAll('.sidebar-nav .nav-item');
    const contentSections = document.querySelectorAll('.content-section');
    const toggleSidebarBtn = document.getElementById('toggleSidebar');
    const adminSidebar = document.getElementById('adminSidebar');

    // Function to show/hide content sections
    function showSection(targetId) {
        contentSections.forEach(section => {
            section.classList.remove('active');
        });
        const activeSection = document.getElementById(targetId);
        if (activeSection) {
            activeSection.classList.add('active');
        }

        // Update active class in sidebar navigation
        navItems.forEach(item => {
            item.classList.remove('active');
            if (item.dataset.target === targetId) {
                item.classList.add('active');
            }
        });
    }

    // Event listeners for main navigation items
    navItems.forEach(item => {
        const targetId = item.dataset.target;
        if (targetId) {
            item.addEventListener('click', function(e) {
                e.preventDefault();
                showSection(targetId);
                // Close sidebar on mobile after clicking
                if (window.innerWidth <= 992) {
                    adminSidebar.classList.remove('open');
                }
            });
        }
    });

    // Sidebar toggle for mobile
    toggleSidebarBtn.addEventListener('click', function() {
        adminSidebar.classList.toggle('open');
        // Adjust main content margin when sidebar is open/closed
        if (adminSidebar.classList.contains('open')) {
            document.querySelector('.admin-main-content').style.marginLeft = '250px';
        } else {
            document.querySelector('.admin-main-content').style.marginLeft = '0';
        }
    });

    // Close sidebar if window resized from small to large
    window.addEventListener('resize', function() {
        if (window.innerWidth > 992) {
            adminSidebar.classList.remove('open');
            document.querySelector('.admin-main-content').style.marginLeft = '250px';
        } else {
            // Re-apply 0 margin if sidebar is explicitly closed on mobile
            if (!adminSidebar.classList.contains('open')) {
                 document.querySelector('.admin-main-content').style.marginLeft = '0';
            }
        }
    });

    // Initial load: show Dashboard
    showSection('dashboard-content');

    // Chart.js for dashboard
    const salesChartCanvas = document.getElementById('monthlySalesChart');
    if (salesChartCanvas) {
        new Chart(salesChartCanvas, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                datasets: [{
                    label: 'Pendapatan Bulanan (Rp)',
                    data: [3000000, 4500000, 5000000, 6200000, 7000000, 7500000, 8000000, 7800000, 8500000, 9000000, 9500000, 10000000],
                    backgroundColor: 'rgba(52, 152, 219, 0.2)',
                    borderColor: 'rgba(52, 152, 219, 1)',
                    borderWidth: 2,
                    tension: 0.3,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return 'Rp ' + value.toLocaleString('id-ID');
                            }
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });
    }
});

// Utility function for showing sections from buttons within sections
function showSection(targetId) {
    const contentSections = document.querySelectorAll('.content-section');
    const navItems = document.querySelectorAll('.sidebar-nav .nav-item');
    contentSections.forEach(section => {
        section.classList.remove('active');
    });
    const activeSection = document.getElementById(targetId);
    if (activeSection) {
        activeSection.classList.add('active');
    }
    navItems.forEach(item => {
        item.classList.remove('active');
        if (item.dataset.target === targetId) {
            item.classList.add('active');
        }
    });
}