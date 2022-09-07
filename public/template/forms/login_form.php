<main class="form-signin w-100 m-auto">
    <div class="text-center">
        <img class="mb-4" src="../../assets/bootstrap-logo.svg" alt="" width="72" height="57">
        <h1 class="h3 mb-3 fw-normal">Please sign in</h1>
    </div>    

    <div id="errorMsg" class="alert alert-danger visually-hidden" role="alert">
    A simple danger alert—check it out!
    </div>

    <div class="form-floating">
      <input type="email" class="form-control" id="username" placeholder="Username">
      <label for="username">Username</label>
    </div>
    <div class="form-floating">
      <input type="password" class="form-control" id="password" placeholder="Password">
      <label for="password">Password</label>
    </div>

    <button class="w-100 btn btn-lg btn-primary" onclick='login("customer","customers")'>Sign in</button>
    
   <p class="my-4" >Not have an account? <a href="/customers/createAccount">Register</a></p> 
    <p class="mt-5 mb-3 text-muted"><?php $year = date("Y"); echo "&copy; $year"; ?></p>
</main>
