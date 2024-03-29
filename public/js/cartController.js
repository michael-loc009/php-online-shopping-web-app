function openCart() {
  const modal = document.getElementById("cartModal");
  // When the user clicks the button, open the modal
  modal.style.display = "block";
  // const html = renderItemDetails(item);
  // document.getElementById("modal-body").innerHTML = html;

  // When the user clicks anywhere outside of the modal, close it
  window.onclick = function (event) {
    if (event.target == modal) {
      modal.style.display = "none";
    }
  };

  //render Cart
  const cart = getCart();
  renderCart(cart);
}

function renderCart(cart) {
  renderCartItems(cart);
  renderCartFooter(cart);
  renderCartQuantity(cart);
}
function closeCart() {
  const modal = document.getElementById("cartModal");
  modal.style.display = "none";
}

function getLoginedUser() {
  const loginedUser = localStorage.getItem("customer");
  if (loginedUser) {
    return JSON.parse(loginedUser);
  }
  return null;
}

function getCart() {
  const localCart = localStorage.getItem("cart");
  const user = getLoginedUser();
  if (localCart && user) {
    const cart = JSON.parse(localCart);
    const { Username } = user;
    const cartByUsername = cart[Username];
    if (cartByUsername) {
      return cartByUsername;
    }
    return [];
  }
  return [];
}

function deleteCartItem(id) {
  const cart = getCart();
  console.log(id);
  const filteredCart = cart.filter(
    (item) => item.item.ProductID.toString() !== id.toString()
  );
  saveCartToLocalStorage(filteredCart);
  renderCart(filteredCart);
}

function renderCartItem(cartItem) {
  const { item, quantity } = cartItem;
  const {
    CreatedAt,
    UpdatedAt,
    Description,
    ImagePath,
    Price,
    Name,
    ProductID,
  } = item;

  const totalPrice = (Price * quantity).toFixed(1);
  return ` <div class="card rounded-3 mb-4">
  <div class="card-body p-4">
     <div class="row d-flex justify-content-between align-items-center">
        <div class="col-md-2 col-lg-2 col-xl-2">
           <img
              src="${ImagePath}"
              class="img-fluid rounded-3" alt="${ProductID}">
        </div>
        <div class="col-md-3 col-lg-3 col-xl-3">
           <p class="lead fw-normal mb-2">${Name}</p>
           <p><span class="text-muted">${Description}</p>
        </div>
        <div class="col-md-3 col-lg-3 col-xl-2 d-flex">
           <button class="btn btn-link px-2"
              onclick="changeQuantity(${ProductID},'minus')">
           <i class="fas fa-minus"></i>
           </button>
           <input id="item-quantity-${ProductID}" onchange="changeQuantity(${ProductID},'input')" min="0" name="quantity" value="${quantity}"
              class="form-control form-control-sm" />
           <button class="btn btn-link px-2"
           onclick="changeQuantity(${ProductID},'plus')">
           <i class="fas fa-plus"></i>
           </button>
        </div>
        <div class="col-md-3 col-lg-2 col-xl-2 offset-lg-1">
           <h5 class="mb-0">$${totalPrice}</h5>
        </div>
        <div class="col-md-1 col-lg-1 col-xl-1 text-end">
           <a onclick="deleteCartItem(${ProductID})" href="#!" class="text-danger"><i class="fas fa-trash fa-lg"></i></a>
        </div>
     </div>
  </div>
  </div>`;
}

function getCartTotal(cart) {
  let cartTotal = 0;
  for (let cartItem of cart) {
    const { item, quantity } = cartItem;
    cartTotal += quantity * item.Price;
  }
  return cartTotal;
}
function renderCartFooter(cart) {
  let cartTotal = getCartTotal(cart);
  let html = `<div class="card mb-4">
    <div class="card-body d-flex align-items-center justify-content-between">
       <button onclick="clearCart()" type="button" class="btn btn-danger btn-block">Clear cart</button>
       <h3 id="cart-total">$${cartTotal.toFixed(1)}</h3>
    </div>
  </div>
  <div class="card">
    <div class="card-body">
    <div class="container">
    <header class="d-flex flex-wrap justify-content-center ">
      <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-dark text-decoration-none">
       
      </a>

      <ul class="nav nav-pills">
      <button onclick="closeCart()" type="button" class="btn btn-secondary btn-block ">Close</button>
      <button onclick="checkout()" type="button" class="btn btn-warning btn-block  ms-3">Checkout</button>
      </ul>
    </header>
  </div>
    </div>
  </div>
  
  `;
  if (cart.length === 0) {
    html = "";
  }
  document.getElementById("cart-footer").innerHTML = html;
}

function renderCartItems(list) {
  let html;
  if (list.length === 0) {
    // if list is empty
    html = "<h3>There is no item in cart. Please add more !</h3>";
  } else {
    html = list.map(renderCartItem).join("");
  }
  document.getElementById("cart-items").innerHTML = html;
}

function renderCartQuantity(list) {
  let quantity = 0;
  for (let cartItem of list) {
    quantity += cartItem.quantity;
  }
  const html = `(${quantity})`;
  document.getElementById("cart-quantity").innerHTML = html;
}

function clearCart() {
  renderCart([]);
  saveCartToLocalStorage([]);
}

function changeQuantity(id, type) {
  const cart = getCart();
  const selectedCartItemIndex = cart.findIndex(
    (cartItem) => cartItem.item.ProductID == id
  );
  if (selectedCartItemIndex > -1) {
    const { quantity } = cart[selectedCartItemIndex];
    let newQuantity = quantity;
    if (type === "minus" && newQuantity > 1) {
      newQuantity--;
    }
    if (type === "plus") {
      newQuantity++;
    }
    if (type === "input") {
      const quantityInput = document.getElementById(
        `item-quantity-${id}`
      ).value;
      newQuantity = quantityInput;
    }
    cart[selectedCartItemIndex].quantity = newQuantity;
    saveCartToLocalStorage(cart);
    renderCart(cart);
  }
}

function checkoutSuccess() {
  alert("Checkout successfully !");
  clearCart();
  closeCart();
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
    onCloseProductDetailsModal();
  }
}

function saveCartToLocalStorage(currentCart) {
  const localCart = localStorage.getItem("cart");
  const loginedUser = localStorage.getItem("customer");
  if (loginedUser) {
    const user = JSON.parse(loginedUser);
    const { Username } = user;
    let cart = {};
    if (localCart) {
      cart = JSON.parse(localCart);
    }
    cart[Username] = currentCart;
    const stringtifiedCart = JSON.stringify(cart);
    localStorage.setItem("cart", stringtifiedCart);
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

async function checkout() {
  const cart = getCart();
  const cartTotal = getCartTotal(cart);
  const user = getLoginedUser();
  const body = {
    CustomerID: user.CustomerID,
    Total: cartTotal,
    OrderItems: cart.map((cartItem) => {
      return {
        ProductID: cartItem.item.ProductID,
        Quantity: cartItem.quantity,
      };
    }),
  };

  let url = `http://php-online-shopping-backend.herokuapp.com//api/api/order`;
  let http = createCORSRequest("post", url);
  http.open("POST", url);
  http.send(JSON.stringify(body)); // Make sure to stringify
  http.onload = function (response) {
    // Do whatever with response
    if (http.status === 201) {
      checkoutSuccess();
    } else {
      alert("There is something wrong when checkout! Please try again");
    }
  };
}

function index() {
  const cart = getCart();
  renderCartQuantity(cart);
}

index();
