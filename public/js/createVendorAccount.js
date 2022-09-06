// import { patternName } from "../constant/validation";

function createCORSRequest(method, url) {
  var xhr = new XMLHttpRequest();
  if ("withCredentials" in xhr) {
    xhr.open(method, url, true);
  } else if (typeof XDomainRequest != "undefined") {
    xhr = new XDomainRequest();
    xhr.open(method, url);
  } else {
    xhr = null;
  }
  return xhr;
}
function createAccount(e) {
  const host = "https://php-online-shopping-backend.herokuapp.com/api/";
    var pattern = /^[a-zA-Z0-9_ ]{5,}$/i;
  var patternAddress = /^[a-zA-Z0-9_ ]{5,}$/i;
  var patternUsern = /^[a-zA-Z0-9_]{8,15}$/i;
  var patternPwd =
    /^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*])([a-zA-Z0-9!@#$%^&*]{8,})$/;
  let name = document.getElementById("inputBusinessName").value;
  let username = document.getElementById("inputUsername").value;
  let pw = document.getElementById("inputPassword").value;
  let pwConfirm = document.getElementById("inputPasswordConfrim").value;
  let address = document.getElementById("inputAddress").value;
  let file = document.getElementById("inputGetFile");
  let status = true;
  let error = "";

  if (!pattern.test(name)) {
    status = false;
    error += `Name at least 5 characters <br>`;
    let element = document.getElementById("inputBusinessName");
    element.classList.add("border-danger");
  } else {
    let element = document.getElementById("inputBusinessName");
    element.classList.remove("border-danger");
  }

  if (!patternUsern.test(username)) {
    status = false;
    error += `Username required, contains only letters and numbers, 8 to 15 characters , unique<br>`;
    let element = document.getElementById("inputUsername");
    element.classList.add("border-danger");
  } else {
    let element = document.getElementById("inputUsername");
    element.classList.remove("border-danger");
  }

  if (!patternPwd.test(pw)) {
    status = false;
    error += `Password required, contains at least one upper case letter, one lower case letter, one digit and one special characters, 8 to 20 characters <br>`;
    let element = document.getElementById("inputPassword");
    element.classList.add("border-danger");
  } else {
    let element = document.getElementById("inputPassword");
    element.classList.remove("border-danger");
  }

  if (!pwConfirm) {
    status = false;
    let element = document.getElementById("inputPasswordConfrim");
    element.classList.add("border-danger");
  } else {
    let element = document.getElementById("inputPasswordConfrim");
    element.classList.remove("border-danger");
  }

  if (pwConfirm !== pw) {
    console.log(pwConfirm, pw);
    status = false;
    error += `Password and Confrim Password not match <br>`;
  }

  if (!patternAddress.test(address)) {
    let element = document.getElementById("inputAddress");
    element.classList.add("border-danger");
    status = false;
    error += `Adress less than 5 characters`;
  } else {
    let element = document.getElementById("inputAddress");
    element.classList.remove("border-danger");
  }

  if (!status) {
    document.getElementById("error").innerHTML = error;
  } else {
    try {
      var xhr = createCORSRequest("post", `${host}product`);
      xhr.addEventListener(
        "progress",
        function (e) {
          var done = e.position || e.loaded,
            total = e.totalSize || e.total;
          console.log(
            "xhr progress: " + Math.floor((done / total) * 1000) / 10 + "%"
          );
        },
        false
      );
      if (xhr.upload) {
        xhr.upload.onprogress = function (e) {
          var done = e.position || e.loaded,
            total = e.totalSize || e.total;
          console.log(
            "xhr.upload progress: " +
              done +
              " / " +
              total +
              " = " +
              Math.floor((done / total) * 1000) / 10 +
              "%"
          );
        };
      }
      xhr.onreadystatechange = function (e) {
        console.log(this.readyState);
        if (4 == this.readyState) {
          console.log(["xhr upload complete----", this.responseText]);
          const res = JSON.parse(this.responseText);
          if (res.code === 9) {
            document.getElementById("error").innerHTML = res.message;
          }
          if (res.status) {
            document.getElementById("error").innerHTML = "";
            alert("Create success");
          }
        }
      };
      xhr.open("POST", `${host}vendor`, true);
      var formData = new FormData();
      formData.append("Username", username);
      formData.append("Password", pw);
      formData.append("BusinessName", name);
      formData.append("BusinessAddress", address);
      if (file.files[0]) {
        console.log("hello");
        formData.append("ProfilePhoto", file.files[0]);
      }
      xhr.send(formData);
    } catch (error) {
      console.log(error.message);
    }
  }
}
