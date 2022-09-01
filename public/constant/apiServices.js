const host = "http://php-online-shopping-backend.herokuapp.com/api/";

export async function callAPI(method, url) {
  const xhttp = new XMLHttpRequest();
  const apiUrl = `${host}${url}`;
  xhttp.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      const responseJsonObj = JSON.parse(this.responseText);
      return responseJsonObj;
    }
  };
  xhttp.open(method, apiUrl, true);
  xhttp.send();
}
