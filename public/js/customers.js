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

function renderItemDetails(item) {
  const {
    CreatedAt,
    UpdatedAt,
    Description,
    ImagePath,
    Price,
    Name,
    ProductID,
  } = item;
  return `<div class="card">
  <div class="row">
      <div class="col-md-6">
          <div class="images p-3">
              <div class="text-center p-4"> <img id="main-image" src="${ImagePath}" width="100%" height="100%"> </div>
          </div>
      </div>
      <div class="col-md-6">
          <div class="product p-4">
                  <h5 class="text-uppercase">${Name}</h5>
                  <div class="price d-flex flex-row align-items-center"> <span class="act-price">$${Price}</span>
                  </div>
              </div>
              <p class="about">${Description}</p>
             
              <div class="cart mt-4 align-items-center"> <button onclick="addToCart(${ProductID})" class="btn btn-success text-uppercase mr-2 px-4">Add to cart</button> <i class="fa fa-heart text-muted"></i> <i class="fa fa-share-alt text-muted"></i> </div>
          </div>
      </div>
  </div>
</div>`;
}

function onCloseProductDetailsModal() {
  const modal = document.getElementById("productDetailsModal");
  document.getElementById("modal-body").innerHTML = "";
  modal.style.display = "none";
}

function openProductDetails(id) {
  const item = vendors.find((item) => item.ProductID == id);
  if (item) {
    const modal = document.getElementById("productDetailsModal");
    // When the user clicks the button, open the modal
    modal.style.display = "block";
    const html = renderItemDetails(item);
    document.getElementById("modal-details-body").innerHTML = html;

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function (event) {
      if (event.target == modal) {
        modal.style.display = "none";
      }
    };
  }
}

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
          <button onclick="openProductDetails(${ProductID})" type="button" class="btn btn-outline-dark me-2">Details</button>
          <button onclick="addToCart(${ProductID})" type="button" class="btn btn-success">Add to cart</button>
        </div>
      </div>
    </div>
  </header>
  </div>
</div>`;
}

function renderList(list) {
  let html;
  if (list.length === 0) {
    // if list is empty
    html = "<h3>There is no products. Please add more !</h3>";
  } else {
    html = list.map(renderItem).join("");
  }
  
  let listEle = document.getElementById("vendorsList");
  if (listEle){
    listEle.innerHTML = html;
  }
}

function getCart() {
  const localCart = localStorage.getItem("cart");
  if (localCart) {
    return JSON.parse(localCart);
  }
  return [];
}

function saveCartToLocalStorage(cart) {
  const stringtifiedCart = JSON.stringify(cart);
  localStorage.setItem("cart", stringtifiedCart);
}

function addToCart(id) {
  const item = vendors.find((item) => item.ProductID == id);
  const cart = getCart();
  if (item) {
    const itemIndex = cart.findIndex(
      (cartItem) => cartItem.item.ProductID == item.ProductID
    );
    // Already have item in cart
    if (itemIndex > -1) {
      cart[itemIndex].quantity += 1;
    }
    // This item havent been in cart
    else {
      cart.push({
        item,
        quantity: 1,
      });
    }
    saveCartToLocalStorage(cart);
    renderCartQuantity(cart);
  }
}

function renderCartQuantity(list) {
  let quantity = 0;
  for (let cartItem of list) {
    quantity += cartItem.quantity;
  }
  const html = `(${quantity})`;
  document.getElementById("cart-quantity").innerHTML = html;
}

function resultBySearchString(list, searchString) {
  return list.filter((vendor) =>
    vendor.Name.toLowerCase().includes(searchString.toLowerCase())
  );
}

function resultByPrice(list, min, max) {
  let result;
  result = list.filter(
    (vendor) => parseFloat(vendor.Price) >= parseFloat(min)
    // &&
    // max &&
    // parseFloat(vendor.Price) <= parseFloat(max)
  );
  if (max) {
    result = result.filter(
      (vendor) => parseFloat(vendor.Price) <= parseFloat(max)
    );
  }
  return result;
}

function searchVendors(e) {
  console.log(vendors.length);
  e.preventDefault();
  const searchString = document.getElementById("search-input").value;
  let minPrice = document.getElementById("minPrice-input").value;
  let maxPrice = document.getElementById("maxPrice-input").value;
  if (minPrice === "") {
    minPrice = 0;
  }
  let result = resultBySearchString(vendors, searchString);
  result = resultByPrice(result, minPrice, maxPrice !== "" && maxPrice);
  renderList(result);
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
