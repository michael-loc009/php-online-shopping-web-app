<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>PHP Online Shopping Project</title>
    <link href="../../css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="../../css/vendors.css" />
  </head>
  <body>
    <div class="container">
      <div class="container">
        <div class="container border px-3 py-3">
          <p class="h1 text-center">CREATE SHIPER ACCOUNT</p>
          <p class="h7 text-danger" id="error"></p>
          <div class="mb-3 row">
            <div class="col">
              <label class="form-label">Distribution Hub (*)</label>
              <select class="form-select" id="list_option"></select>
            </div>
            <div class="col">
              <label class="form-label">User Name (*)</label>
              <input
                type="text"
                class="form-control"
                id="inputUsername"
                minlength="10"
                maxlength="20"
              />
            </div>
          </div>
          <div class="mb-3 row">
            <div class="col">
              <label class="form-label">Password (*)</label>
              <input type="password" class="form-control" id="inputPassword" />
            </div>
            <div class="col">
              <label class="form-label">Confirm Password (*)</label>
              <input
                type="password"
                class="form-control"
                id="inputPasswordConfrim"
              />
            </div>
          </div>
          <div class="mb-3">
            <label class="form-label">Profile Image</label>
            <input
              type="file"
              class="form-control"
              id="inputGetFile"
              accept="image/png, image/jpeg, image/jpg"
            />
          </div>
          <button
            type="submit"
            class="btn btn-primary"
            id="#btn-submit"
            onclick="createAccount(event)"
          >
            Create
          </button>
        </div>
      </div>
    </div>
    <script src="../../js/bootstrap.bundle.min.js"></script>
    <script src="../../constant/apiServices.js"></script>
    <script src="../../js/createShipperAccount.js"></script>
  </body>
</html>
