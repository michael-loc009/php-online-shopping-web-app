function triggerErrorMessage(msg, action) {
    let elem = document.getElementById("errorMsg");

    if (action == "show") {
        elem.classList.remove("visually-hidden");
        elem.innerHTML = msg;
    } else {
        elem.classList.add("visually-hidden");
        elem.innerHTML = "";
    }
}

function checkEmpty(input, fieldName) {

    if (input.trim().length <= 0) {
        return `${fieldName}  is required.`;
    }

    return "";
}

function logout(accountType, redirectLink) {
    if (accountType == "customer") {
        localStorage.removeItem("customer");
        window.location.replace(`http://${window.location.host}/${redirectLink}/login`);
        return;
    }

    if (accountType == "vendor") {
        localStorage.removeItem("vendor");
        window.location.replace(`http://${window.location.host}/${redirectLink}/login`);
        return;
    }

    if (accountType == "shipper") {
        localStorage.removeItem("shipper");
        window.location.replace(`http://${window.location.host}/${redirectLink}/login`);
        return;
    }
}

function authenticate(accountType, redirectLink) {

    let userProfile = localStorage.getItem(accountType);
    if (userProfile === null) {
        window.location.replace(`http://${window.location.host}/${redirectLink}/login`);
        return;
    }

    userProfile = JSON.parse(userProfile);
    let ele = document.getElementById("usernameBanner");
    ele.innerHTML = `Hello, <strong> ${userProfile.Username} </strong>`;
}

function generateAccountProfile(accountType) {
    let userProfile = localStorage.getItem(accountType);

    if (userProfile !== null) {
        userProfile = JSON.parse(userProfile);

        let profilePhotoEle = document.getElementById("userProfilePhoto");
        profilePhotoEle.src = userProfile.ProfilePhoto;

        let usernameEle = document.getElementById("userProfileUserName");
        usernameEle.innerHTML = userProfile.Username;

        let updateProfilePhotoAccountIDEle = document.getElementById("updateProfilePhotoAccountID");
        if (accountType === "customer") {
            updateProfilePhotoAccountIDEle.value = userProfile.CustomerID;
        } else if (accountType === "shipper") {
            updateProfilePhotoAccountIDEle.value = userProfile.ShipperID;
        } else {
            updateProfilePhotoAccountIDEle.value = userProfile.VendorID;
        }

        let updateProfilePhotoAccountUsernameEle = document.getElementById("updateProfilePhotoAccountUsername");
        updateProfilePhotoAccountUsernameEle.value = userProfile.Username;

        let updateProfilePhotoAccountTypeEle = document.getElementById("updateProfilePhotoAccountType");
        updateProfilePhotoAccountTypeEle.value = accountType;

        let htmlProfile = "";
        let userProfileDetailsEle = document.getElementById("userProfileDetails");
        for (const property in userProfile) {
            if (property === "ProfilePhoto") {
                continue;
            }
            htmlProfile += `<div class="row"><div class="col-sm-3"><p class="mb-0">${property}</p></div><div class="col-sm-9"><p class="text-muted mb-0">${userProfile[property]}</p></div></div><hr/>`;
        }
        userProfileDetailsEle.innerHTML = htmlProfile;
    }
}

function updateProfilePhotoPathForStore(accountType,path){
    let userProfile = localStorage.getItem(accountType);
    userProfile = JSON.parse(userProfile);
    userProfile.ProfilePhoto = path;
    userProfile = JSON.stringify(userProfile);
    localStorage.setItem(accountType, userProfile);
}