<!-- Sidebar -->
  <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
      <div class="sidebar-brand-icon rotate-n-15">
        <i class="fas fa-code"></i>
      </div>
      <div class="sidebar-brand-text mx-3">Point of Sales </div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
      <b>Main Navigation</b>
    </div>

    <li class="nav-item <?= $this->uri->segment(1) == 'admin'|| $this->uri->segment(1) == '' ? 'active' : '' ?>">
      <a class="nav-link" href="<?= base_url('admin'); ?>">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>Dashboard</span></a>
    </li>

    <!-- <li class="nav-item">
      <a class="nav-link" href="">
        <i class="fas fa-fw fa-users"></i>
        <span>Customers</span></a>
    </li> -->

    <li class="nav-item <?= $this->uri->segment(1) == 'item'|| $this->uri->segment(1) == 'category' ? 'active' : '' ?>">
      <a class="nav-link <?= $this->uri->segment(1) == 'item'|| $this->uri->segment(1) == 'category' ? '' : 'collapsed' ?>" href="#" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseTwo">
        <i class="fas fa-fw fa-inbox"></i>
        <span>Products</span>
      </a>
      <div id="collapseOne" class="collapse <?= $this->uri->segment(1) == 'item'|| $this->uri->segment(1) == 'category' ? 'show' : '' ?>" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
          <a class="collapse-item" href="<?= base_url('category'); ?>">Kategori</a>
          <a class="collapse-item" href="<?= base_url('item'); ?>">Item</a>
        </div>
      </div>
    </li>

    <li class="nav-item">
      <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
        <i class="fas fa-fw fa-shopping-cart"></i>
        <span>Transaction</span>
      </a>
      <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
          <a class="collapse-item" href="<?= base_url('category'); ?>">Sales</a>
          <a class="collapse-item" href="<?= base_url('stock/stockin'); ?>">Stock In</a>
          <a class="collapse-item" href="<?= base_url('item'); ?>">Stock Out</a>
        </div>
      </div>
    </li>

    <?php if($this->session->userdata('role_id') == 1 || $this->session->userdata('role_id') == 2) { ?>
      <li class="nav-item <?= $this->uri->segment(1) == 'report' ? 'active' : '' ?>">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseThree" aria-expanded="true" aria-controls="collapseTwo">
          <i class="fas fa-fw fa-edit"></i>
          <span>Reports</span>
        </a>
        <div id="collapseThree" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Custom Components:</h6>
            <a class="collapse-item" href="buttons.html">Buttons</a>
            <a class="collapse-item" href="cards.html">Cards</a>
          </div>
        </div>
      </li>

      <li class="nav-item <?= $this->uri->segment(1) == 'supplier' ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('supplier'); ?>">
          <i class="fas fa-fw fa-truck"></i>
          <span>Suppliers</span></a>
      </li>

      <li class="nav-item <?= $this->uri->segment(1) == 'user' ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('user'); ?>">
          <i class="fas fa-fw fa-user"></i>
          <span>User</span></a>
      </li>
    <?php } ?>

    <!-- Divider -->
    <hr class="sidebar-divider mt-3">

    <li class="nav-item">
      <a class="nav-link" href="<?= base_url('auth/logout'); ?>">
        <i class="fas fa-fw fa-sign-out-alt"></i>
        <span>Logout</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
      <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

  </ul>
  <!-- End of Sidebar -->