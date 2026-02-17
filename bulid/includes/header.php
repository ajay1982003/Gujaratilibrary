<!-- Header File -->
<nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme" id="layout-navbar">
    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
            <i class="bx bx-menu bx-sm"></i>
        </a>
    </div>

    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
        
        <!-- Date Display (Left Side) -->
        <div class="navbar-nav align-items-center">
            <div class="nav-item d-flex align-items-center">
                <i class="bx bx-calendar fs-4 lh-0 me-2"></i>
                <span class="fw-semibold text-muted"><?php echo date('l, d M Y'); ?></span>
            </div>
        </div>

        <ul class="navbar-nav flex-row align-items-center ms-auto">
         

            <!-- User Name -->
            <li class="nav-item lh-1 me-3 d-flex align-items-center">
                <i class="bx bx-user-circle fs-4 me-2"></i>
                <span class="fw-semibold"><?php echo htmlspecialchars(SessionHelper::getUsername() ?? 'Guest'); ?></span>
            </li>

            <!-- Logout Button -->
            <li class="nav-item">
                <a href="logout.php" class="btn btn-sm btn-outline-danger">
                    <i class="bx bx-power-off me-1"></i> Logout
                </a>
            </li>
        </ul>
    </div>
</nav>