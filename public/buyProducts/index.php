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
         <!-- Section -->
         <div id="products">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
               <div class="container-fluid">
                  <form class="d-flex">
                     <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                     <button class="btn btn-outline-success" type="submit">Search</button>
                  </form>
               </div>
            </nav>
            <div class="album py-5  ">
               <div id="vendorsList"  class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3 "> 
               </div>
               <div>
                  <!-- <ul class="pagination">
                     <li id="btn_prev" class="page-item"><a class="page-link">Previous</a></li>
                     <li id="btn_next" class="page-item"><a class="page-link">Next</a></li>
                     </ul> -->
               </div>
               </nav>
            </div>
         </div>
          <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Modal Header</h4>
        </div>
        <div class="modal-body">
          <p>Some text in the modal.</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
      </div>
      
      <?php include "../template/footers/admin_footer.php"; ?>  
      <script src="../js/bootstrap.bundle.min.js"></script>
      <script src="../js/buyProducts.js"></script>
   </body>
</html>