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
  const { OrderStatusID, Label } = item;

  return `    <tr>
  <th scope="row">${OrderStatusID}</th>
  <td>Mark</td>
  <td>Otto</td>
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
          Update status
        </button>
        <ul class="dropdown-menu">
          <li><a class="dropdown-item" href="#">Delivered</a></li>
          <li>
            <a class="dropdown-item" href="#">Cancelled</a>
          </li>
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

async function index() {
  try {
    const onSuccess = (response) => {
      if (Array.isArray(response)) {
        console.log(response);
        renderList(response);
        console.log(response);
        // changePage(1);
        // renderPagination(response);
      }
    };
    await callAPI("GET", "/api/orderStatus", onSuccess);
  } catch (err) {
    console.log(err);
  }
}

index();
