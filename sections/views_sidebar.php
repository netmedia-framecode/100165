<?php foreach ($views_auth as $data) { ?>
  <ul class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar" style="background-color: <?= $data['bg'] ?>;">
  <?php } ?>

  <!-- Sidebar - Brand -->
  <a class="sidebar-brand d-flex align-items-center justify-content-center" href="./">
    <div class="sidebar-brand-icon rotate-n-15">
      <i class="bi bi-code-slash"></i>
    </div>
    <div class="sidebar-brand-text mx-3"><?= $name_website ?></div>
  </a>

  <!-- Divider -->
  <hr class="sidebar-divider my-0">

  <!-- Nav Item - Dashboard -->
  <li class="nav-item active">
    <a class="nav-link" href="./">
      <i class="fas fa-fw fa-tachometer-alt"></i>
      <span>Dashboard</span></a>
  </li>

  <!-- Divider -->
  <hr class="sidebar-divider">

  <!-- Heading -->
  <?php
  $queryMenu = "SELECT user_menu.id_menu, user_menu.menu
                FROM user_menu JOIN user_access_menu
                ON user_menu.id_menu = user_access_menu.id_menu
                WHERE user_access_menu.id_role = '$id_role'
                ORDER BY user_access_menu.id_menu ASC
              ";
  $menu = mysqli_query($conn, $queryMenu);
  foreach ($menu as $m) :
  ?>
    <div class="sidebar-heading">
      <?= $m['menu']; ?>
    </div>

    <!-- Nav Item - Pages Collapse Menu -->
    <?php
    $menuId = $m['id_menu'];
    $querySubMenu = "SELECT * FROM user_sub_menu 
                    JOIN user_menu ON user_sub_menu.id_menu = user_menu.id_menu
                    JOIN user_access_sub_menu ON user_sub_menu.id_sub_menu=user_access_sub_menu.id_sub_menu
                    WHERE user_sub_menu.id_menu = $menuId
                    AND user_sub_menu.id_active = 1
                    AND user_access_sub_menu.id_role = '$id_role'
                  ";
    $subMenu = mysqli_query($conn, $querySubMenu);
    foreach ($subMenu as $sm) :
      if ($_SESSION['project_prediksi_pertumbuhan_penduduk']['name_page'] == $sm['title']) : ?>
        <li class="nav-item active">
        <?php else : ?>
        <li class="nav-item">
        <?php endif; ?>
        <a class="nav-link pb-0" href="<?= $sm['url']; ?>">
          <i class="<?= $sm['icon']; ?>"></i>
          <span><?= $sm['title']; ?></span></a>
        </li>
      <?php endforeach; ?>

      <!-- Divider -->
      <hr class="sidebar-divider d-none d-md-block mt-3">

    <?php endforeach; ?>

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
      <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

  </ul>