function openUpdateProfilePhotoModal() {
    const modal = document.getElementById("updateProfilePhotoModal");
    modal.style.display = "block";

    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    };
}

function closeUpdateProfilePhotoModal() {
    const modal = document.getElementById("updateProfilePhotoModal");
    modal.style.display = "none";
}

function updateProfilePhoto() {

    let fileInput = document.getElementById("updateProfilePhoto");

    if (fileInput.files.length <= 0) {
        triggerErrorMessage("Uploaded file is empty", "show");
        return;
    }

    let updateProfilePhotoAccountID = document.getElementById("updateProfilePhotoAccountID").value;
    let updateProfilePhotoAccountUsername = document.getElementById("updateProfilePhotoAccountUsername").value;
    let updateProfilePhotoAccountType = document.getElementById("updateProfilePhotoAccountType").value;

    let data = new FormData();
    data.append("ProfilePhoto", fileInput.files[0]);
    data.append("Username", updateProfilePhotoAccountUsername);
    data.append("Type", updateProfilePhotoAccountType);

    if (updateProfilePhotoAccountType === "customer") {
        data.append("CustomerID", updateProfilePhotoAccountID);
    } else if (updateProfilePhotoAccountType === "shipper") {
        data.append("ShipperID", updateProfilePhotoAccountID);
    } else {
        data.append("VendorID", updateProfilePhotoAccountID);
    }

    let url = `${host}profile-photo`;
    let xhr = createCORSRequest("post", url);

    xhr.addEventListener("readystatechange", function() {
        if (this.readyState === 4) {
            let { status = 0 } = this;

            if (status == 200) {
                let newPath = `${apiHost}/assets/${updateProfilePhotoAccountType}s/${updateProfilePhotoAccountUsername}/${fileInput.files[0].name}`;
                let profilePhotoEle = document.getElementById("userProfilePhoto");
                profilePhotoEle.src = newPath;
                updateProfilePhotoPathForStore(updateProfilePhotoAccountType,newPath);
                window.location.replace(`http://${window.location.host}/${updateProfilePhotoAccountType}s/profile`);
                return;
            }

            if (status == 400) {
                let response = JSON.parse(this.responseText);
                triggerErrorMessage(response.message, "show");
                return;
            }
        }
    });

    xhr.open("POST", url);

    xhr.send(data);

}