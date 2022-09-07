<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Customer</title>

    <!-- Favicons -->
    <link rel="icon" href="../../assets/favicon.ico">

    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../css/customers.css">
    <script src="https://kit.fontawesome.com/a8c4c24db6.js" crossorigin="anonymous"></script>
</head>

<body>
    <?php include "../template/headers/customer_header.php"; ?>
    <div class="container">
        <!-- Section -->
        <div id="products">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container-fluid">
                    <form class="d-flex justify-content-between">
                        <div class="d-flex">
                            <input id="search-input" class="form-control me-2" type="search" placeholder="Search"
                                aria-label="Search">
                            <input id="minPrice-input" class="form-control me-2" type="number" placeholder="Min Price"
                                aria-label="MinPrice">
                            <input id="maxPrice-input" class="form-control me-2" type="number" placeholder="Max Price"
                                aria-label="MaxPrice">
                        </div>
                        <button onclick="searchVendors(event)" class="btn btn-outline-success">Filter</button>
                    </form>
                </div>
            </nav>
            <div class="album py-5  ">
                <div id="vendorsList" class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3 ">
                </div>
                </nav>
            </div>
        </div>
    </div>
    <!-- Modal Product Details -->
    <div id="productDetailsModal" class="modal">
        <!-- Modal content -->
        <div class="modal-content">
            <span onclick="onCloseProductDetailsModal()" class="close">&times;</span>
            <div id="modal-details-body"></div>
        </div>
    </div>

    <?php include "../template/footers/admin_footer.php"; ?>
    <script src="../js/bootstrap.bundle.min.js"></script>
    <script src="../js/customers.js"></script>
    <script src="../js/cartController.js"></script>
    <script src="../js/helpers.js"></script>
</body>

</html>
<script>
    window.onload = authenticate("customer", "customers");
</script>