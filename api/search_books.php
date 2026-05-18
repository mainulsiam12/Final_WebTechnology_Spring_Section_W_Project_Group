<?php

header("Content-Type: application/json");

$conn = mysqli_connect(
    "localhost",
    "root",
    "",
    "library_management_system"
);

$q = $_GET['q'];

$search = "%$q%";

$sql = "

SELECT books.*,
genres.name as genre_name,

(
    books.total_copies -

    COUNT(
        CASE
        WHEN borrow_records.status = 'Active'
        THEN 1
        END
    )

) as available_copies

FROM books

LEFT JOIN genres
ON books.genre_id = genres.id

LEFT JOIN borrow_records
ON books.id = borrow_records.book_id

WHERE title LIKE ?
OR author LIKE ?
OR isbn LIKE ?

GROUP BY books.id
";

$stmt = mysqli_prepare($conn, $sql);

mysqli_stmt_bind_param(
    $stmt,
    "sss",
    $search,
    $search,
    $search
);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

$data = [];

while($row = mysqli_fetch_assoc($result)) {

    $data[] = $row;
}

echo json_encode($data);

?>