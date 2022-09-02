<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Vendor</title>
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/vendors.css">
  </head>
  <body>
    <?php include "../template/headers/admin_header.php"; ?>
      <div class="container">
        <!-- Tabs -->
      <ul class="nav nav-pills">
  <li class="nav-item " >
    <a onclick="openSection(event, 'products')"  class="nav-link tablinks active" href="#">Products</a>
  </li>
  <li class="nav-item ">
    <a  onclick="openSection(event, 'create-products')" class="nav-link tablinks" href="#">Add new product</a>
  </li>
</ul>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
   
      <form class="d-flex">
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success" type="submit">Search</button>
      </form>
    </div>
  </div>
</nav>
        <!-- Section -->
        <div class="album py-5  ">
          <div id="products" class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3 tabcontent"> 
            
          </div>
          <div id="create-products" class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3 tabcontent"> 
            
            </div>
          <nav aria-label="Page navigation example">
      <div>
    <!-- <ul class="pagination">
    <li id="btn_prev" class="page-item"><a class="page-link">Previous</a></li>
    <li id="btn_next" class="page-item"><a class="page-link">Next</a></li>
    </ul> -->
      </div>
 
</nav>
        </div>
      </div>
    <?php include "../template/footers/admin_footer.php"; ?>  
    <script src="../js/bootstrap.bundle.min.js"></script>
    <script src="../const/apiServices.js"></script> 
    <script src="../js/vendors.js"></script>
    
  </body>
</html>