<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Vendor</title>
    <link rel="icon" href="../../assets/favicon.ico" />
    <link href="../css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="../css/vendors.css" />
  </head>
  <body>
    <?php include "../template/headers/vendor_header.php"; ?>
    <div class="container">
      <!-- Tabs -->
      <ul class="nav nav-pills mb-5">
        <li class="nav-item">
          <a
            onclick="openSection(event, 'products')"
            class="nav-link tablinks active"
            href="#"
            >Products</a
          >
        </li>
        <li class="nav-item">
          <a
            onclick="openSection(event, 'create-products')"
            class="nav-link tablinks"
            href="#"
            >Add new product</a
          >
        </li>
      </ul>
      <!-- Section -->
      <div id="products" class="tabcontent">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
          <div class="container-fluid">
            <form class="d-flex">
              <input
                id="search-input"
                class="form-control me-2"
                type="search"
                placeholder="Search"
                aria-label="Search"
              />
              <button
                class="btn btn-outline-success"
                onclick="searchVendors(event)"
              >
                Search
              </button>
            </form>
          </div>
        </nav>
        <div class="album py-5">
          <div
            id="list-vendor"
            class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3"
          ></div>
        </div>
      </div>
      <div id="create-products" class="tabcontent">
        <?php include "./addProduct/index.php"; ?>
      </div>
    </div>
    <?php include "../template/footers/admin_footer.php"; ?>
    <script src="../js/bootstrap.bundle.min.js"></script>
    <script src="../constant/time.js"></script>
    <script src="../constant/apiServices.js"></script>
    <script src="../js/helpers.js"></script>
    <script src="../js/vendors.js"></script>
    <script src="../js/addProduct.js"></script>
    <script>
      window.onload = authenticate("vendor", "vendors");
    </script>
  </body>
</html>
