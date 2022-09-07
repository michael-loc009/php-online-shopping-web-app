const maxItemPerPage = 2;
let currentPage = 1;
let vendors = [];
let orderStatus = [];
let orders = [];

const openSection = (evt, sectionName) => {
  var i, tabcontent, tablinks;

  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }

  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace("active", "");
  }

  document.getElementById(sectionName).style.display = "block";
  evt.currentTarget.className += " active";
};

async function callAPI(method, url, onSuccess) {
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

async function updateStatus(orderID, statusID) {
  const body = {
    OrderID: orderID,
    OrderStatusID: statusID,
  };

  let url = `http://php-online-shopping-backend.herokuapp.com//api/api/order`;
  let http = createCORSRequest("put", url);
  http.open("PUT", url);
  http.send(JSON.stringify(body)); // Make sure to stringify
  http.onload = function (response) {
    // Do whatever with response
    console.log(response, http);
    if (http.status === 201) {
      // checkoutSuccess();
    }
  };
}

function renderItem(item, index) {
  const { OrderID, CreatedAt, Total, StatusLabel, Status } = item;
  const date = new Date(CreatedAt);
  return ` <tr>
  <th scope="row">${OrderID}</th>
  <td>${date.getDate()}/${date.getMonth()}/${date.getFullYear()} - ${date.getHours()}:${date.getMinutes()}:${date.getSeconds()} </td>
  <td>$${Total}</td>
  <td>
    <div class="btn-group">
      <div class="dropdown">
      <button
          class="btn btn-secondary"
          type="button"
        >
          Detail
        </button>

        <button
          class="btn btn-secondary dropdown-toggle"
          type="button"
          data-bs-toggle="dropdown"
          aria-expanded="false"
        >
          ${StatusLabel.toUpperCase()}
        </button>
        <ul class="dropdown-menu">
          ${orderStatus
            .filter((status) => status.OrderStatusID !== Status)
            .map((status) => {
              return `<li>
            <a class="dropdown-item" href="#">${status.Label.toUpperCase()}</a>
          </li>`;
            })}
        </ul>
      </div>
    </div>
  </td>
</tr>`;
}

function renderList(list) {
  let html;
  if (list.length === 0) {
    // if list is empty
    html = "<h3>There is no order";
  } else {
    html = list.map(renderItem).join("");
  }
  document.getElementById("list-item").innerHTML = html;
}

async function getOrderStatus() {
  const onSuccess = (response) => {
    if (Array.isArray(response)) {
      console.log(response);
      orderStatus = response;
      getOrdersByDistributionHubID();
    }
  };
  await callAPI("GET", "/api/orderStatus", onSuccess);
}

function getLoginedShipper() {
  const logined = localStorage.getItem("shipper");
  if (logined) {
    return JSON.parse(logined);
  }
  return null;
}

async function getOrdersByDistributionHubID() {
  const shipper = getLoginedShipper();
  if (shipper) {
    const { DistributionHubID } = shipper;
    const onSuccess = (response) => {
      if (Array.isArray(response)) {
        console.log(response);
        orders = response;
        renderList(response);
      }
    };
    await callAPI(
      "GET",
      `/api/order?DistributionHubID=${DistributionHubID}`,
      onSuccess
    );
  }
}

async function index() {
  try {
    await getOrderStatus();
    // await getOrdersByDistributionHubID();
  } catch (err) {
    console.log(err);
  }
}

index();
