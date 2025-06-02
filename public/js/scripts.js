document.addEventListener('DOMContentLoaded', function() {
    const sidebarToggleBtn = document.getElementById('sidebarToggleBtn');
    const sidebar = document.getElementById('adminSidebar');
    
    // Initialize sidebar state
    function initSidebar() {
        // Check if we're on mobile or desktop
        const isMobile = window.innerWidth < 992;
        
        if (isMobile) {
            // On mobile, start with sidebar hidden
            sidebar.classList.remove('sidebar-collapsed');
            sidebar.classList.remove('show');
            localStorage.setItem('sidebarCollapsed', 'false');
        } 
    }
    
    // Toggle sidebar function
    function toggleSidebar() {
        const isMobile = window.innerWidth < 992;
        
        if (isMobile) {
            // For mobile, toggle the 'show' class
            sidebar.classList.toggle('show');
        } 
    }
    
    // Initialize sidebar on load
    initSidebar();
    
    // Add click event to toggle button
    if (sidebarToggleBtn) {
        sidebarToggleBtn.addEventListener('click', toggleSidebar);
    }
    
    // Close mobile sidebar when clicking outside
    document.addEventListener('click', function(event) {
        const isMobile = window.innerWidth < 992;
        const isClickInsideSidebar = sidebar.contains(event.target);
        const isClickOnToggleBtn = sidebarToggleBtn.contains(event.target);
        
        if (isMobile && !isClickInsideSidebar && !isClickOnToggleBtn) {
            sidebar.classList.remove('show');
        }
    });
    
    // Handle window resize
    window.addEventListener('resize', function() {
        initSidebar();
    });
    
    // Highlight active menu item
    const currentPath = window.location.pathname;
    document.querySelectorAll('.sidebar-link').forEach(link => {
        if (link.getAttribute('href') === currentPath) {
            link.classList.add('active');
        }
    });
});