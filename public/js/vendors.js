const host = "http://php-online-shopping-backend.herokuapp.com/api/";
const maxItemPerPage = 2;
let currentPage = 1;
let vendors = [];

const openSection = (evt, sectionName) => {
  var i, tabcontent, tablinks;

  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }

  tablinks = document.getElementsByClassName("tablinks");
  console.log(tablinks);
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace("active", "");
  }

  document.getElementById(sectionName).style.display = "block";
  evt.currentTarget.className += " active";
};

function prevPage() {
  if (currentPage > 1) {
    currentPage--;
    changePage(currentPage);
  }
}

function nextPage() {
  if (currentPage < numPages()) {
    current_page++;
    changePage(current_page);
  }
}

const renderPagination = (items) => {
  const paginationList = document.getElementById("pagination");
  //   <li class="page-item"><a class="page-link" href="#">Previous</a></li>
  //   <li class="page-item"><a class="page-link" href="#">1</a></li>
  //   <li class="page-item"><a class="page-link" href="#">2</a></li>
  //   <li class="page-item"><a class="page-link" href="#">3</a></li>
  //   <li class="page-item"><a class="page-link" href="#">Next</a></li>
  //   return ``
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
  </div>
</div>`;
}

function changePage(page) {
  var btn_prev = document
    .getElementById("btn_prev")
    .addEventListener("click", prevPage);
  var btn_next = document
    .getElementById("btn_next")
    .addEventListener("click", nextPage);
  //   btn_next.addEventListener("click", nextPage, false);

  var page_span = document.getElementById("page");

  // Validate page
  if (page < 1) page = 1;
  if (page > numPages()) page = numPages();

  const list = [];
  for (
    var i = (page - 1) * maxItemPerPage;
    i < page * maxItemPerPage && i < vendors.length;
    i++
  ) {
    if (vendors[i]) {
      list.push(vendors[i]);
    }
  }
  renderList(list);

  //   if (page == 1) {
  //     btn_prev.style.visibility = "hidden";
  //   } else {
  //     btn_prev.style.visibility = "visible";
  //   }

  //   if (page == numPages()) {
  //     btn_next.style.visibility = "hidden";
  //   } else {
  //     btn_next.style.visibility = "visible";
  //   }
}

function numPages() {
  return Math.ceil(vendors / maxItemPerPage);
}

function renderList(list) {
  let html;
  if (list.length === 0) {
    // if list is empty
    html = "<h3>There is no products. Please add more !</h3>";
  } else {
    html = list.map(renderItem).join("");
  }
  document.getElementById("vendorsList").innerHTML = html;
}

async function index() {
  try {
    const onSuccess = (response) => {
      if (Array.isArray(response)) {
        vendors = response;
        renderList(vendors);
        // changePage(1);
        renderPagination(response);
      }
    };
    await callAPI("GET", "/api/product", onSuccess);
  } catch (err) {
    console.log(err);
  }
}

index();
