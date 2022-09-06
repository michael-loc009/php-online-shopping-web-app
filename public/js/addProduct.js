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

function _addProduct(e) {
  const host = "https://php-online-shopping-backend.herokuapp.com/api/";

  let name = document.getElementById("inputName").value;
  let price = document.getElementById("inputPrice").value;
  let desc = document.getElementById("inputDescription").value;
  let file = document.getElementById("inputGetFile");
  let status = true;
  if (name) {
    name = name.trim();
    if (name.length < 10 || name.lenght > 20) {
      let element = document.getElementById("inputName");
      element.classList.add("border-danger");
      status = false;
      e.preventDefault();
    }
  } else if (!name) {
    let element = document.getElementById("inputName");
    element.classList.add("border-danger");
    status = false;
    e.preventDefault();
  }

  if (!price || price === 0) {
    let element = document.getElementById("inputPrice");
    element.classList.add("border-danger");
    status = false;
    e.preventDefault();
  }
  if (!file.files[0]) {
    let element = document.getElementById("inputGetFile");
    element.classList.add("border-danger");
    status = false;
    e.preventDefault();
  }

  if (status) {
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
          if (res.code === 5) {
            document.getElementById("error").innerHTML = res.message;
          }
          if (res.status) {
            document.getElementById("error").innerHTML = "";
            alert("Create success");
          }
        }
      };
      xhr.open("POST", `${host}product`, true);
      var formData = new FormData();
      formData.append("Name", name);
      formData.append("Price", price);
      formData.append("Description", desc);
      formData.append("ProductPhoto", file.files[0]);
      xhr.send(formData);
      console.log(formData);
    } catch (error) {
      console.log(error.message);
    }
  }
}
