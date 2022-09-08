<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Customer Profile</title>

    <!-- Favicons -->
    <link rel="icon" href="../../assets/favicon.ico">

    <link href="../../css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../../css/customers.css">
    <link rel="stylesheet" href="../../css/profile.css">
    <script src="https://kit.fontawesome.com/a8c4c24db6.js" crossorigin="anonymous"></script>
</head>

<body>
    <?php include "../../template/headers/customer_header.php"; ?>
   
    <?php include "../../template/cards/profile_card.php" ?>
    <?php include "../../template/footers/admin_footer.php"; ?>

    <script src="../../js/bootstrap.bundle.min.js"></script>
    <script src="../../js/helpers.js"></script>
    <script src="../../constant/apiServices.js"></script>
    <script src="../../js/customers.js"></script>
    <script src="../../js/cartController.js"></script>
    <script src="../../js/updateProfilePhoto.js"></script>

</body>

</html>
<script>
    window.onload = function () {
        authenticate("customer", "customers");
        generateAccountProfile("customer");
    };
</script>