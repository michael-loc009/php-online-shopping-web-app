<section class="h-100 gradient-custom-2">
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col col-lg-9 col-xl-7">
                <div class="card">
                    <div class="rounded-top text-white d-flex flex-row bg-secondary py-3 profile-container">
                        <div class="ms-4 mt-5 d-flex flex-column" >
                            <img id="userProfilePhoto" src="" alt="Profile photo" width="150"
                                class="img-fluid img-thumbnail mt-4 mb-2">
                            <button onclick="openUpdateProfilePhotoModal()" type="button" id="btnOpenUpdateProfilePhoto" class="btn btn-primary" data-mdb-ripple-color="dark">
                                Edit profile photo
                            </button>
                        </div>
                        <div class="ms-4 mx-5 profile-photo">
                            <h5 id="userProfileUserName"></h5>
                        </div>
                    </div>
                    <div class="p-4 text-black">
                    </div>
                    <div class="card-body p-4 text-black">
                        <div class="mb-5 mt-5">
                            <p class="lead fw-normal mb-1">About</p>
                            <div class="p-4">

                                <div id="userProfileDetails" class="card-body">
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <p class="mb-0">Full Name</p>
                                        </div>
                                        <div class="col-sm-9">
                                            <p class="text-muted mb-0">Johnatan Smith</p>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <p class="mb-0">Email</p>
                                        </div>
                                        <div class="col-sm-9">
                                            <p class="text-muted mb-0">example@example.com</p>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <p class="mb-0">Phone</p>
                                        </div>
                                        <div class="col-sm-9">
                                            <p class="text-muted mb-0">(097) 234-5678</p>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <p class="mb-0">Mobile</p>
                                        </div>
                                        <div class="col-sm-9">
                                            <p class="text-muted mb-0">(098) 765-4321</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Modal -->
<div class="modal" id="updateProfilePhotoModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="updateProfilePhotoModalLabel">Update Profile Photo</h5>
        <button onclick="closeUpdateProfilePhotoModal()"  type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <div class="mb-3">
      <label for="updateProfilePhoto" class="form-label">Please choose an image to update your account profile photo</label>
    <input class="form-control" accept="image/png, image/jpeg, image/jpg" type="file" id="updateProfilePhoto">
</div>
      </div>
      <div class="modal-footer">
        <button onclick="closeUpdateProfilePhotoModal()" type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>