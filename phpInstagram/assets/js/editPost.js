const modalDelete = document.getElementById("modalDelete");
const openDelete = document.getElementById("openDelete");
const closeButton2 = document.getElementsByClassName("close")[0];

function modal() {
    openDelete.addEventListener("click", () => {
        modalDelete.style.display = "flex";
        document.body.style.overflow = 'hidden'
    });

// Loop through the closeButton2 collection and add event listeners to each element

    closeButton2.addEventListener("click", () => {
        modalDelete.style.display = "none";

        document.body.style.overflow = 'visible'
    });

    window.addEventListener("click", (event) => {
        if (event.target === modalDelete) {
            modalDelete.style.display = "none";

            document.body.style.overflow = 'visible'
        }
    });
}

modal()

function deleteImg(img_id, images_count) {
    const url = "../../action/deleteImageAction.php";
    const data = new URLSearchParams();

    if (images_count == 1) {
        modalDelete.style.display = "flex";
    } else {
        data.append('image_id', img_id);
        fetch(url, {
            method: "POST",
            body: data,
            headers: {
                "Content-Type": 'application/x-www-form-urlencoded'
            }
        })
            .then(response => response.text())
            .then(result => {
                console.log(result)
                let img = document.getElementById(`image${img_id}`);
                console.log(`image${img_id}`)
                if (img) {
                    img.parentNode.removeChild(img);
                    window.location.reload()
                }
            })
            .catch(error => {
                console.log(error);
            });
    }

}
