<div id="badge"></div>

<script>

function loadAvailability(book_id){

    fetch('api/books/availability.php?book_id=' + book_id)

    .then(response => response.json())

    .then(data => {

        let badge = document.getElementById('badge');

        if(data.available_copies > 0){

            badge.innerHTML =
            '<span style=\"color:green\">Available</span>';

        }else{

            badge.innerHTML =
            '<span style=\"color:red\">Unavailable</span>';

        }

    });

}

loadAvailability(1);

</script>