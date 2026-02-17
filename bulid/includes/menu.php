<!-- Menu -->
<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
require_once __DIR__ . '/../app/helpers/SessionHelper.php';

$username = SessionHelper::getUsername();
$email = SessionHelper::getUserEmail();
?>
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme ">
  <div class="app-brand demo">
    <a href="index.php" class="app-brand-link">
      <span class="app-brand-logo demo">
        <img style=" height: 80px;" src="assets/images/image.png" alt="" class="w-100">

      </span>
      <span class="app-brand-text demo menu-text fw-bolder ms-1" style="font-size: 18Px;">Gujarati Library</span>
    </a>

    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
      <i class="bx bx-chevron-left bx-sm align-middle"></i>
    </a>
  </div>

  <div class="menu-inner-shadow"></div>

  <ul class="menu-inner py-1">
    <!-- User Info -->
    <?php if (SessionHelper::isLoggedIn()): ?>
    <li class="menu-item">
      <a href="javascript:void(0);" class="menu-link">
        <i class="menu-icon tf-icons bx bx-user"></i>
        <div data-i18n="User">
          <small><?php echo htmlspecialchars($username); ?></small><br>
          <small style="font-size: 0.7rem; opacity: 0.7;"><?php echo htmlspecialchars($email); ?></small>
        </div>
      </a>
    </li>
    <li class="menu-divider"></li>
    <?php
endif; ?>

    <!-- Dashboard -->
    <li class="menu-item">
      <a href="index.php" class="menu-link">
        <i class="menu-icon tf-icons bx bx-home-circle"></i>
        <div data-i18n="Analytics">Dashboard</div>
      </a>
    </li>

    <!-- Library Management -->
    <li class="menu-header small text-uppercase">
      <span class="menu-header-text">Library</span>
    </li>
    
    <!-- Books -->
    <li class="menu-item">
      <a href="books.php" class="menu-link">
        <i class="menu-icon tf-icons bx bx-book"></i>
        <div data-i18n="Books">Books</div>
      </a>
    </li>

    <!-- Book History -->
    <li class="menu-item">
      <a href="book-history.php" class="menu-link">
        <i class="menu-icon tf-icons bx bx-history"></i>
        <div data-i18n="Book History">Book History</div>
      </a>
    </li>

       <!-- Users-->
    <li class="menu-item">
      <a href="users.php" class="menu-link">
        <i class="menu-icon tf-icons bx bx-user"></i>
        <div data-i18n="Users">Users</div>
      </a>
    </li>

    <!-- Logout -->
    <li class="menu-divider"></li>
    <li class="menu-item">
      <a href="logout.php" class="menu-link">
        <i class="menu-icon tf-icons bx bx-log-out"></i>
        <div data-i18n="Logout">Logout</div>
      </a>
    </li>

    
  </ul>
</aside>
<!-- / Menu -->
