<?php foreach ($views_auth as $data) { ?>
<ul class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar"
  style="background-color: <?= $data['bg'] ?>;">
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
  <div class="sidebar-heading">
    Kelola Data
  </div>

  <!-- Nav Item - Pages Collapse Menu -->
  <li class="nav-item">
    <a class="nav-link pb-0" href="periode">
      <i class="fas fa-list-ol"></i>
      <span>Periode</span></a>
  </li>
  <li class="nav-item">
    <a class="nav-link pb-0" href="variabel">
      <i class="fas fa-list-ol"></i>
      <span>Variabel</span></a>
  </li>
  <li class="nav-item">
    <a class="nav-link pb-0" href="dataset">
      <i class="fas fa-list-ol"></i>
      <span>Dataset</span></a>
  </li>
  <li class="nav-item">
    <a class="nav-link pb-0" href="prediksi">
      <i class="fas fa-list-ol"></i>
      <span>Prediksi</span></a>
  </li>

  <!-- Divider -->
  <hr class="sidebar-divider">

  <!-- Heading -->
  <div class="sidebar-heading">
    Laporan
  </div>
  <li class="nav-item">
    <a class="nav-link pb-0" href="ringkasan-hasil">
      <i class="fas fa-list-ol"></i>
      <span>Ringkasan Hasil</span></a>
  </li>

  <!-- Divider -->
  <hr class="sidebar-divider">

  <!-- Heading -->
  <div class="sidebar-heading">
    Lainnya
  </div>
  <li class="nav-item">
    <a class="nav-link pb-0" href="tentang">
      <i class="fas fa-list-ol"></i>
      <span>Tentang</span></a>
  </li>

  <!-- Divider -->
  <hr class="sidebar-divider d-none d-md-block mt-3">

  <!-- Sidebar Toggler (Sidebar) -->
  <div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
  </div>

</ul>