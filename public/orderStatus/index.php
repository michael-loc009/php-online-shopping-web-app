<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Vendor</title>
    <link href="../css/bootstrap.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="../css/vendors.css" />
  </head>
  <body>
    <?php include "../template/headers/admin_header.php"; ?>
    <div class="container">
      <div class="container px-3 py-3">
        <p class="h2">Order</p>
        <table class="table">
          <thead>
            <tr>
              <th scope="col">OrderID</th>
              <th scope="col">Create At</th>
              <th scope="col">Total</th>
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody id="list-item">
        
          </tbody>
        </table>
      </div>
    </div>

    <?php include "../template/footers/admin_footer.php"; ?>
    <script src="../js/orderStatus.js"></script>
    <script src="../js/bootstrap.bundle.min.js"></script>
  </body>
</html>
