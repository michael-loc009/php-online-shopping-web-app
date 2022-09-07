let orderStatus = [];
let orders = [];

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

function renderItemDetails(item) {
  console.log(item);
  let htmlProfile = "";
  let orderDetailsHTML = "";
  for (let itemDetails of item.OrderDetails) {
    const orderDetails = JSON.parse(itemDetails);
    for (let order of orderDetails) {
      for (let property in order) {
        orderDetailsHTML += `<div class="row"><div class="col-sm-3"><p class="mb-0">${property}</p></div><div class="col-sm-9"><p class="text-muted mb-0">${order[property]}</p></div></div><hr/>`;
      }
    }
  }
  for (const property in item) {
    if (property === "OrderDetails" || property === "Status") {
      continue;
    }
    htmlProfile += `<div class="row"><div class="col-sm-3"><p class="mb-0">${property}</p></div><div class="col-sm-9"><p class="text-muted mb-0">${item[property]}</p></div></div><hr/>`;
  }
  htmlProfile = `${htmlProfile}${`<div class="row"><div class="col-sm-3"><p class="mb-0">Order Details</p></div><div class="col-sm-9"><p class="text-muted mb-0">${orderDetailsHTML}</p></div></div><hr/>`}`;
  return htmlProfile;
}

function onCloseOrderDetailsModal() {
  const modal = document.getElementById("orderDetailsModal");
  document.getElementById("modal-order-details-body").innerHTML = "";
  modal.style.display = "none";
}

function openOrderDetails(id) {
  const item = orders.find((item) => item.OrderID == id);
  if (item) {
    const modal = document.getElementById("orderDetailsModal");
    // When the user clicks the button, open the modal
    modal.style.display = "block";
    const html = renderItemDetails(item);
    document.getElementById("modal-order-details-body").innerHTML = html;

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function (event) {
      if (event.target == modal) {
        modal.style.display = "none";
      }
    };
  }
}

async function updateStatus(orderID, statusID) {
  const body = {
    OrderID: orderID,
    OrderStatusID: statusID,
  };

  let url = `http://php-online-shopping-backend.herokuapp.com//api/api/order`;
  let http = createCORSRequest("PUT", url);
  http.open("PUT", url);
  http.send(JSON.stringify(body)); // Make sure to stringify
  http.onload = function (response) {
    // Do whatever with response
    console.log(response, http);
    if (http.status === 201) {
      // checkoutSuccess();
      location.reload();
    } else {
      alert("Something wrong when update order status ! Please try again");
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
          onclick="openOrderDetails(${OrderID})"
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
            <button onclick="updateStatus(${OrderID},${
                status.OrderStatusID
              })" class="dropdown-item" href="#">${status.Label.toUpperCase()}</button>
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
