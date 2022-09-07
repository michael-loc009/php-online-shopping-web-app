const apiHost = "http://php-online-shopping-backend.herokuapp.com";
const host = `${apiHost}/api/`;

async function callAPI(method, url, onSuccess = () => {}) {
  const xhttp = new XMLHttpRequest();
  const apiUrl = `${host}${url}`;
  xhttp.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      const responseJsonObj = JSON.parse(this.responseText);
      onSuccess(responseJsonObj);
    }
  };
  xhttp.open(method, apiUrl, true);
  xhttp.send();
}

const removeDuplicateSpace = (text) => {
  if (text) {
    let stc = text.trim();
    str = stc.replace(/ +(?= )/g, "");
    return str;
  }
  return "";
};

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