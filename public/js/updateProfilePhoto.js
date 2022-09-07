function openUpdateProfilePhotoModal() {
    const modal = document.getElementById("updateProfilePhotoModal");
    console.log(modal);
    modal.style.display = "block";

    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    };
}

function closeUpdateProfilePhotoModal() {
    const modal = document.getElementById("updateProfilePhotoModal");
    modal.style.display = "none";
  }