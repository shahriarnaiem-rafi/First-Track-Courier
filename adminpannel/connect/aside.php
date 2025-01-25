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

</style>
<aside class="app-sidebar bg-[#FDBCD5] shadow" data-bs-theme="dark">
  <!--begin::Sidebar Brand-->
  <div class="sidebar-brand">
    <!--begin::Brand Link-->
    <a href="./index.php" class="brand-link">
      <!--begin::Brand Image-->
      <img src="../assets/img/adminimg.png" alt="AdminLTE Logo" class="brand-image opacity-75 shadow" />
      <!--end::Brand Image-->
      <!--begin::Brand Text-->
      <span class="brand-text fw-light">Admin</span>
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
        <li class="nav-item menu-open">


          <a href="" class="nav-link active" id="dashboard-btn">
            <i class="fa-solid fa-gauge"></i>
            <p>Dashboard </p>
          </a>

        </li>
        <!-- User Management -->
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



        <!-- Delivery  Management -->
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
              <a href="#" class="nav-link" id="recved_btn">
                <i class="nav-icon bi bi-circle"></i>
                <p>Parcel Recived</p>

              </a>
            </li>
          </ul>
        </li>
        <!-- ENd this section -->

        <!-- Driver Management -->
        <li class="nav-item">
          <a href="#" class="nav-link dashboard-show">
            <i class="fa-regular fa-id-card"></i>
            <p>
              Driver Management
              <i class="nav-arrow bi bi-chevron-right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="#" class="nav-link " id="driver-btn">
                <i class="nav-icon bi bi-circle"></i>
                <p>Drivers</p>
                <!-- Add and manage driver profiles.
View drivers' availability and performance metrics (e.g., completed deliveries).
Assign tasks to drivers. -->
              </a>
            </li>
          </ul>
        </li>

        <!-- Financial Management -->
        <li class="nav-item">
          <a href="#" class="nav-link dashboard-show">
            <i class="fa-solid fa-coins"></i>
            <p>
              Financial Management
              <i class="nav-arrow bi bi-chevron-right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="#" class="nav-link" id="payment-btn">
                <i class="fa-solid fa-money-bill"></i>
                <p>Payments</p>
                <!-- View payment history from customers.
Generate invoices for completed deliveries.
Handle driver payments and commissions.
Display profit/loss analytics. -->
              </a>
            </li>
          </ul>
        </li>


        <!-- branch -->
        <li class="nav-item">
          <a href="#" class="nav-link dashboard-show">
            <i class="fa-solid fa-code-branch"></i>
            <p>
              Branch Management
              <i class="nav-arrow bi bi-chevron-right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="" class="nav-link" id="branch_btn">
                <i class="fa-solid fa-code-branch"></i>
                <p>Create Branch</p>
              </a>
            </li>
          </ul>
        </li>




        <!-- Customer Suport -->
        <li class="nav-item">
          <a href="#" class="nav-link dashboard-show">
            <i class="fa-solid fa-handshake-angle"></i>
            <p>
              Customer Suport
              <i class="nav-arrow bi bi-chevron-right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="#" class="nav-link" id="support-btn">
                <i class="fa-solid fa-handshake-angle"></i>
                <p>Suport</p>
                <!-- View and manage customer queries or complaints.
Respond to queries directly from the admin panel. -->
              </a>
            </li>
          </ul>
        </li>
        <!-- Settings -->

        <li class="nav-item">
          <a href="#" class="nav-link dashboard-show">
            <i class="fa-solid fa-gear"></i>
            <p>
              Settings
              <i class="nav-arrow bi bi-chevron-right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="#" class="nav-link " id="setting-btn">
                <i class="fa-solid fa-gear"></i>
                <p>Settings</p>
                <!-- Change admin profile details.
Configure service zones (areas your courier service covers).
Set delivery charges or pricing models (e.g., per km or flat rate).
Manage notification settings (email/SMS alerts for delivery updates). -->
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="fa-solid fa-user"></i>
            <p>
              Auth
              <i class="nav-arrow bi bi-chevron-right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">

            <li class="nav-item">
              <a href="../../rootfolder/login.php" class="nav-link" id="aurth-login-btn">
                <i class="nav-icon bi bi-circle"></i>
                <p>Login</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="" class="nav-link" id="aurth-registry-btn">
                <i class="nav-icon bi bi-circle"></i>
                <p>Register </p>
              </a>
            </li>
        </li>

      </ul>
      </li>

      <li class="nav-item">
        <a href="../../rootfolder/logout.php" class="nav-link">
          <i class="fa-solid fa-right-to-bracket"></i>
          <p>Log out</p>
        </a>
      </li>

      </ul>
      <!--end::Sidebar Menu-->
    </nav>
  </div>
  <!--end::Sidebar Wrapper-->
</aside>