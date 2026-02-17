<!-- Menu -->
<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
require_once __DIR__ . '/../app/helpers/SessionHelper.php';

$username = SessionHelper::getUsername();
$email = SessionHelper::getUserEmail();
?>

<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">

  <div class="app-brand demo">
    <a href="index.php" class="app-brand-link">
      <span class="app-brand-logo demo">
        <img style="height:80px;" src="assets/images/image.png" class="w-100">
      </span>
      <span class="app-brand-text demo menu-text fw-bolder ms-1" style="font-size:18px;">
        Gujarati Library
      </span>
    </a>

  </div>

  <div class="menu-inner-shadow"></div>

  <ul class="menu-inner py-1">

    <li class="menu-item <?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : ''; ?>">
      <a href="index.php" class="menu-link">
        <i class="menu-icon tf-icons bx bx-home-circle"></i>
        <div>Dashboard</div>
      </a>
    </li>

    <li class="menu-header small text-uppercase">
      <span class="menu-header-text">Library</span>
    </li>

    <li class="menu-item <?php echo basename($_SERVER['PHP_SELF']) == 'books.php' ? 'active' : ''; ?>">
      <a href="books.php" class="menu-link">
        <i class="menu-icon tf-icons bx bx-book"></i>
        <div>Books</div>
      </a>
    </li>

    <li class="menu-item <?php echo basename($_SERVER['PHP_SELF']) == 'book-history.php' ? 'active' : ''; ?>">
      <a href="book-history.php" class="menu-link">
        <i class="menu-icon tf-icons bx bx-history"></i>
        <div>Book History</div>
      </a>
    </li>
<!-- 
    <li class="menu-item">
      <a href="users.php" class="menu-link">
        <i class="menu-icon tf-icons bx bx-user"></i>
        <div>Users</div>
      </a>
    </li> -->

  </ul>
</aside>
<!-- / Menu -->





