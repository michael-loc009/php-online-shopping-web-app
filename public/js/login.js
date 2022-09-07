function login(accountType, redirectLink) {
    let username = document.getElementById("username").value;
    let password = document.getElementById("password").value;


    checkEmptyUsername = checkEmpty(username, "Username");
    checkEmptyPassword = checkEmpty(password, "Password");

    if (checkEmptyUsername != "") {
        triggerErrorMessage(checkEmptyUsername, "show");
        return;
    }

    if (checkEmptyPassword != "") {
        triggerErrorMessage(checkEmptyPassword, "show");
        return;
    }

    var data = JSON.stringify({
        "Username": username,
        "Password": password,
        "Type": accountType
    });

    try {
        let url = `${host}login`;
        let xhr = createCORSRequest("post", url);
        xhr.addEventListener("readystatechange", function() {
            if (this.readyState === 4) {
                let { status = 0 } = this;

                if (status == 200) {
                    localStorage.setItem("customer", this.responseText);
                    window.location.replace(`http://${window.location.host}/${redirectLink}`);
                    return;
                }

                if (status == 400) {
                    let response = JSON.parse(this.responseText);
                    triggerErrorMessage(response.message, "show");
                    return;
                }
            }
        });

        xhr.open("POST", url, true);


        xhr.send(data);
    } catch (error) {
        console.log(error);
    }

}

