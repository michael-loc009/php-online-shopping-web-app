<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Vendor</title>
    <link href="../css/bootstrap.min.css" rel="stylesheet">
  </head>
  <body>
    <?php include "../template/headers/admin_header.php"; ?>
      <div class="container">
        <div class="album py-5 bg-light">
          <div id="vendorsList" class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3"> 
            
          </div>
        </div>
      </div>
    <?php include "../template/footers/admin_footer.php"; ?>  
    <script src="moment.js"></script>
    <script src="../js/bootstrap.bundle.min.js"></script>
    <script src="../const/apiServices.js"></script> 
    <script type="module" src="../js/vendors.js"></script>
    
  </body>
</html>