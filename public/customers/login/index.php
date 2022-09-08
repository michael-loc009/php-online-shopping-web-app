<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Login </title>
        <!-- Favicons -->
    <link rel="icon" href="../../assets/favicon.ico">

        <!-- CSS Files -->
    <link href="../../css/bootstrap.min.css" rel="stylesheet">
    <link href="../../css/login.css" rel="stylesheet">
</head>
<body>
    <?php include "../../template/forms/login_form.php" ?>

    <button class="w-100 btn btn-lg btn-primary" onclick='login("customer","customers")'>Sign in</button>
    
    <p class="my-4" >Not have an account? <a href="/customers/createAccount">Register</a></p> 
     <p class="mt-5 mb-3 text-muted"><?php $year = date("Y"); echo "&copy; $year"; ?></p>
    </main>

    <script src="../../js/bootstrap.bundle.min.js"></script>
    <script src="../../constant/apiServices.js"></script>
    <script src="../../js/helpers.js"></script>
    <script src="../../js/login.js"></script>
</body>
</html>