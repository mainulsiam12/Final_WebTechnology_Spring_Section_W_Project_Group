function payFine(id) {

    let formData = new FormData();

    formData.append("fine_id", id);

    fetch("../../api/fines/pay.php", {

        method: "POST",

        body: formData
    })

    .then(response => response.json())

    .then(data => {

        if(data.success) {

            document
            .getElementById("row-" + id)
            .remove();
        }
    });
}