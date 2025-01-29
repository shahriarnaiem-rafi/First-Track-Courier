document.addEventListener("DOMContentLoaded", function () {
  // Dashboard section
  document.getElementById("dashboard-btn")?.addEventListener("click", function (event) {
    event.preventDefault();
    console.log("Dashboard button clicked");
    const dashboardSection = document.getElementById("dashboard-section");
    if (dashboardSection) {
      dashboardSection.classList.remove("hidden");
    }
    document.getElementById("user-id")?.classList.add("hidden");
    document.getElementById("delivery-orderlist-id")?.classList.add("hidden");
    document.getElementById("delivery-assing-id")?.classList.add("hidden");
    document.getElementById("delivery-track-id")?.classList.add("hidden");
    document.getElementById("parcel-receive-id")?.classList.add("hidden");
  });

  // User management section
  document.getElementById("user-btn")?.addEventListener("click", function (event) {
    event.preventDefault();
    console.log("User Management button clicked");
    const userSection = document.getElementById("user-id");
    if (userSection) {
      userSection.classList.remove("hidden");
    }
    document.getElementById("dashboard-section")?.classList.add("hidden");
    document.getElementById("delivery-orderlist-id")?.classList.add("hidden");
    document.getElementById("delivery-assing-id")?.classList.add("hidden");
    document.getElementById("delivery-track-id")?.classList.add("hidden");
    document.getElementById("parcel-receive-id")?.classList.add("hidden");
  });

  // Delivery management - Order List
  document.getElementById("delivery-order-list-btn")?.addEventListener("click", function (event) {
    event.preventDefault();
    console.log("Order List button clicked");
    const orderListSection = document.getElementById("delivery-orderlist-id");
    if (orderListSection) {
      orderListSection.classList.remove("hidden");
    }
    document.getElementById("dashboard-section")?.classList.add("hidden");
    document.getElementById("user-id")?.classList.add("hidden");
    document.getElementById("delivery-assing-id")?.classList.add("hidden");
    document.getElementById("delivery-track-id")?.classList.add("hidden");
    document.getElementById("parcel-receive-id")?.classList.add("hidden");
  });

  // Delivery management - Assign Drivers
  document.getElementById("delivery-assing-btn")?.addEventListener("click", function (event) {
    event.preventDefault();
    console.log("Assign Drivers button clicked");
    const assignSection = document.getElementById("delivery-assing-id");
    if (assignSection) {
      assignSection.classList.remove("hidden");
    }
    document.getElementById("delivery-orderlist-id")?.classList.add("hidden");
    document.getElementById("dashboard-section")?.classList.add("hidden");
    document.getElementById("user-id")?.classList.add("hidden");
    document.getElementById("delivery-track-id")?.classList.add("hidden");
    document.getElementById("parcel-receive-id")?.classList.add("hidden");
  });

  // Delivery management - Track Info
  document.getElementById("delivery-track-btn")?.addEventListener("click", function (event) {
    event.preventDefault();
    console.log("Track Info button clicked");
    const trackSection = document.getElementById("delivery-track-id");
    if (trackSection) {
      trackSection.classList.remove("hidden");
    }
    document.getElementById("delivery-assing-id")?.classList.add("hidden");
    document.getElementById("delivery-orderlist-id")?.classList.add("hidden");
    document.getElementById("dashboard-section")?.classList.add("hidden");
    document.getElementById("user-id")?.classList.add("hidden");
    document.getElementById("parcel-receive-id")?.classList.add("hidden");
  });

  // Parcel Received Handler
  document.getElementById("parcel-receive-btn")?.addEventListener("click", function (event) {
    event.preventDefault();
    console.log("Parcel Received button clicked");
    const parcelReceivedSection = document.getElementById("parcel-receive-id");
    if (parcelReceivedSection) {
      parcelReceivedSection.classList.remove("hidden");
    }
    document.getElementById("dashboard-section")?.classList.add("hidden");
    document.getElementById("user-id")?.classList.add("hidden");
    document.getElementById("delivery-orderlist-id")?.classList.add("hidden");
    document.getElementById("delivery-assing-id")?.classList.add("hidden");
    document.getElementById("delivery-track-id")?.classList.add("hidden");
  });
});