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

  .app-sidebar .nav-link:hover {
    background-color: rgba(0, 0, 0, 0.1);
  }

  .app-sidebar .nav-link.active {
    background-color: rgba(0, 123, 255, 0.1);
  }

  .app-sidebar .nav-arrow {
    color: black !important;
  }

  .app-sidebar .nav-treeview .nav-item .nav-link {
    font-size: 14px;
    padding-left: 20px;
  }
</style>


<aside class="app-sidebar bg-[#FDBCD5] shadow" data-bs-theme="dark">

  <!--begin::Sidebar Brand-->
  <div class="sidebar-brand">

    <a href="./index.php" class="brand-link">

      <img
        src="./assets/img/adminimg.png"
        alt="Staff"
        class="brand-image opacity-75 shadow" />

      <span class="brand-text fw-light">
        Staff
      </span>

    </a>

  </div>
  <!--end::Sidebar Brand-->


  <!--begin::Sidebar Wrapper-->
  <div class="sidebar-wrapper">

    <nav class="mt-2">

      <!--begin::Sidebar Menu-->
      <ul
        class="nav sidebar-menu flex-column"
        data-lte-toggle="treeview"
        role="menu"
        data-accordion="false">


        <!-- ==============================
             DASHBOARD
        =============================== -->
        <li class="nav-item menu-open">

          <a
            href="#"
            class="nav-link active"
            id="dashboard-btn">

            <i class="fa-solid fa-gauge"></i>

            <p>
              Dashboard
            </p>

          </a>

        </li>


        <!-- ==============================
             CUSTOMER MANAGEMENT
        =============================== -->
        <li class="nav-item">

          <a href="#" class="nav-link">

            <i class="fa-solid fa-people-roof"></i>

            <p>

              Customer Management

              <i class="nav-arrow bi bi-chevron-right"></i>

            </p>

          </a>


          <ul class="nav nav-treeview">

            <li class="nav-item">

              <a
                href="#"
                class="nav-link"
                id="user-btn">

                <i class="nav-icon bi bi-circle"></i>

                <p>
                  Customer Section
                </p>

              </a>

            </li>

          </ul>

        </li>


        <!-- ==============================
             DELIVERY MANAGEMENT
        =============================== -->
        <li class="nav-item">

          <a href="#" class="nav-link">

            <i class="fa-solid fa-truck"></i>

            <p>

              Delivery Management

              <i class="nav-arrow bi bi-chevron-right"></i>

            </p>

          </a>


          <ul class="nav nav-treeview">


            <!-- Order Details -->
            <li class="nav-item">

              <a
                href="#"
                class="nav-link"
                id="delivery-order-list-btn">

                <i class="nav-icon bi bi-circle"></i>

                <p>
                  Order Details
                </p>

              </a>

            </li>


            <!-- Assign Drivers -->
            <li class="nav-item">

              <a
                href="#"
                class="nav-link"
                id="delivery-assing-btn">

                <i class="nav-icon bi bi-circle"></i>

                <p>
                  Assign Drivers
                </p>

              </a>

            </li>


            <!-- Tracking -->
            <li class="nav-item">

              <a
                href="#"
                class="nav-link"
                id="delivery-track-btn">

                <i class="nav-icon bi bi-circle"></i>

                <p>
                  Tracking Info
                </p>

              </a>

            </li>


            <!-- Parcel Received -->
            <li class="nav-item">

              <a
                href="#"
                class="nav-link"
                id="parcel-receive-btn">

                <i class="nav-icon bi bi-circle"></i>

                <p>
                  Parcel Received
                </p>

              </a>

            </li>


          </ul>

        </li>


        <!-- ==============================
             LOGOUT
        =============================== -->
        <li class="nav-item">

          <a href="/First-Track-Courier/rootfolder/logout.php" class="nav-link">


            <i class="fa-solid fa-right-from-bracket"></i>

            <p>
              Log Out
            </p>

          </a>

        </li>


      </ul>
      <!--end::Sidebar Menu-->

    </nav>

  </div>
  <!--end::Sidebar Wrapper-->

</aside>