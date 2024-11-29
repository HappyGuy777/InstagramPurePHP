// Get the modal and close button elements
const modalPass = document.getElementById("modalPass");
const openPassword = document.getElementById("openPassword");
const closeButton = document.getElementsByClassName("close")[0];


const modalDelete = document.getElementById("modalDelete");
const openDelete = document.getElementById("openDelete");
const closeButton2 = document.getElementsByClassName("close")[1];
// Function to open the modal
openPassword.addEventListener("click", () => {
    modalPass.style.display = "flex";
});

// Function to close the modal
closeButton.addEventListener("click", () => {
    modalPass.style.display = "none";
});

// Close the modal if the user clicks outside of it
window.addEventListener("click", (event) => {
    if (event.target === modalPass) {
        modalPass.style.display = "none";
    }
});

openDelete.addEventListener("click", () => {
    modalDelete.style.display = "flex";
});
closeButton2.addEventListener("click", () => {
    modalDelete.style.display = "none";
});

window.addEventListener("click", (event) => {
    if (event.target === modalDelete) {
        modalDelete.style.display = "none";
    }
});