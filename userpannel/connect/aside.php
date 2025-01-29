<style>
  .app-sidebar {
    color: black !important;
  }

  .app-sidebar .nav-link,
  .app-sidebar .brand-text,
  .app-sidebar .nav-item p {
    color: black !important;
  }

  .app-sidebar .nav-icon,
  .app-sidebar .fa-solid,
  .app-sidebar .fa-regular,
  .app-sidebar .bi {
    color: black !important;
  }

  /* Hover effect for links */
  .app-sidebar .nav-link:hover {
    background-color: rgba(0, 0, 0, 0.1);
    color: #007bff;
    /* Change link color on hover */
  }

  .app-sidebar .nav-link.active {
    background-color: rgba(0, 123, 255, 0.1);
    /* Highlight active link */
    color: #007bff;
  }

  .app-sidebar .nav-arrow {
    color: black !important;
  }

  /* Optional: style for sub-menu items */
  .app-sidebar .nav-treeview .nav-item .nav-link {
    font-size: 14px;
    padding-left: 20px;
  }
</style>

<aside class="app-sidebar bg-[#FDBCD5] shadow" data-bs-theme="dark">
  <!--begin::Sidebar Brand-->
  <div class="sidebar-brand">
    <!--begin::Brand Link-->
    <a href="./index.php" class="brand-link">
      <!--begin::Brand Image-->
      <img src="./assets/img/adminimg.png" alt="AdminLTE Logo" class="brand-image opacity-75 shadow" />
      <!--end::Brand Image-->
      <!--begin::Brand Text-->
      <span class="brand-text fw-light">Staff</span>
      <!--end::Brand Text-->
    </a>
    <!--end::Brand Link-->
  </div>
  <!--end::Sidebar Brand-->

  <!--begin::Sidebar Wrapper-->
  <div class="sidebar-wrapper">
    <nav class="mt-2">
      <!--begin::Sidebar Menu-->
      <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">
        <!-- Dashboard -->
        <li class="nav-item menu-open">
          <a href="" class="nav-link active" id="dashboard-btn">
            <i class="fa-solid fa-gauge"></i>
            <p>Dashboard</p>
          </a>
        </li>
        <!-- Customer Management -->
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="fa-solid fa-people-roof"></i>
            <p class="text-[15px]">
              Customer Management
              <i class="nav-arrow bi bi-chevron-right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item" disabled>
              <a href="#" class="nav-link" id="user-btn">
                <i class="nav-icon bi bi-circle"></i>
                <p>Customer Section</p>
              </a>
            </li>
          </ul>
        </li>

        <!-- Delivery Management -->
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="fa-solid fa-truck"></i>
            <p>
              Delivery Management
              <i class="nav-arrow bi bi-chevron-right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="#" class="nav-link" id="delivery-order-list-btn">
                <i class="nav-icon bi bi-circle"></i>
                <p>Order Details</p>
                <!-- Order list : Order List: A table with columns like order ID, customer name, pickup location, delivery location, status, etc.-->
              </a>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link" id="delivery-assing-btn">
                <i class="nav-icon bi bi-circle"></i>
                <p>Assign Drivers</p>
                <!-- Assign delivery staff or vehicles to specific orders.-->
              </a>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link" id="delivery-track-btn">
                <i class="nav-icon bi bi-circle"></i>
                <p>Tracking Info</p>
                <!--  Update or view tracking numbers for shipments.-->
              </a>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link" id="parcel-receive-btn">
                <i class="nav-icon bi bi-circle"></i>
                <p>Parcel Received</p>
              </a>
            </li>
          </ul>
        </li>

        <!-- Log Out -->
        <li class="nav-item">
          <a href="../rootfolder/login.php" class="nav-link">
            <i class="fa-solid fa-right-to-bracket"></i>
            <p>Log Out</p>
          </a>
        </li>

      </ul>
      <!--end::Sidebar Menu-->
    </nav>
  </div>
  <!--end::Sidebar Wrapper-->
</aside>