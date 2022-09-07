<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Shipper</title>
    <!-- Favicons -->
    <link rel="icon" href="../../assets/favicon.ico" />
    <link href="../css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="../css/shippers.css" />
  </head>
  <body>
    <?php include "../template/headers/shipper_header.php"; ?>
    <div class="container">
      <div class="container px-3 py-3">
        <p class="h2">Orders</p>
        <table class="table">
          <thead>
            <tr>
              <th scope="col">OrderID</th>
              <th scope="col">Create At</th>
              <th scope="col">Total</th>
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody id="list-item"></tbody>
        </table>
      </div>
    </div>

    <?php include "../template/footers/admin_footer.php"; ?>
    <script src="../js/bootstrap.bundle.min.js"></script>
    <script src="../constant/apiServices.js"></script>
    <script src="../js/shipper.js"></script>
    <script src="../js/helpers.js"></script>
    <script>
      window.onload = authenticate("shipper", "shippers");
    </script>
  </body>
</html>
