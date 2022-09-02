const host = "http://php-online-shopping-backend.herokuapp.com/api/";
const maxItemPerPage = 2;
let currentPage = 1;
let vendors = [];

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

function openProductDetailsModal() {}

function renderItem(item, index) {
  const {
    CreatedAt,
    UpdatedAt,
    Description,
    ImagePath,
    Price,
    Name,
    ProductID,
  } = item;

  return `<div class="col">
  <div class="card shadow-sm">
    <div>
    <img src="${ImagePath}" alt="product ${ProductID}" width="100%" height="250">
    </div>
    <div class="card-body">
    <div class="d-flex justify-content-between align-items-center">
    <p>${Name}</p>
    <p>${Price}</p>
    </div>
      <p class="card-text">Description: ${Description}</p>
      <div class="d-flex justify-content-between align-items-center">
        <small class="text-muted">Last updated:9 mins</small>
      </div>
    </div>
    <header class="p-3 text-bg-light">
    <div class="container">
      <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
        <div class="text-end">
          <button type="button" class="btn btn-outline-dark me-2">Details</button>
          <button type="button" class="btn btn-danger">Buy</button>
        </div>
      </div>
    </div>
  </header>
  </div>
</div>`;
}

function renderList(list) {
  console.log({ list });
  let html = list.map(renderItem).join("");
  document.getElementById("vendorsList").innerHTML = html;
}

async function index() {
  try {
    const onSuccess = (response) => {
      if (Array.isArray(response)) {
        vendors = response;
        renderList(vendors);
      }
    };
    await callAPI("GET", "/api/product", onSuccess);
  } catch (err) {
    console.log(err);
  }
}

index();
