function createAccount() {
  var patternUsern = /^[a-zA-Z0-9_]{8,15}$/i;
  var patternPwd =
    /^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*])([a-zA-Z0-9!@#$%^&*]{8,})$/;

  let hub = document.getElementById("list_option").value;
  let username = document.getElementById("inputUsername").value;
  let pw = document.getElementById("inputPassword").value;
  let pwConfirm = document.getElementById("inputPasswordConfrim").value;
  let file = document.getElementById("inputGetFile");
  let status = true;
  let error = "";
  document.getElementById("error").innerHTML = "";

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
  if (!status) {
    document.getElementById("error").innerHTML = error;
  }else{
    var xhr = createCORSRequest("post", `${host}shipper`);
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
      var formData = new FormData();
      formData.append("Username", username);
      formData.append("Password", pw);
      formData.append("DistributionHubID", hub);
      if (file.files[0]) {
        formData.append("ProfilePhoto", file.files[0]);
      }
      xhr.send(formData);
  }
}

const renderOption = (list_option) => {
  let _value = "";
  list_option.map((item, index) => {
    const { Address, DistributionHubID, Name } = item;
    _value += `<option value="${DistributionHubID}">${Name} - Address:${Address}</option>`;
  });
  document.getElementById("list_option").innerHTML = _value;
};

async function index() {
  try {
    const onSuccess = (response) => {
      if (Array.isArray(response)) {
        renderOption(response);
      }
    };
    await callAPI("GET", "/api/distributionHub", onSuccess);
  } catch (err) {
    console.log(err);
  }
}

index();
