<?php
$conn = mysqli_connect('localhost', 'root', '', 'gallery');
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$totalDataPerPage = 12;
$totalData = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM images"));
$totalPage = ceil($totalData / 12);
$activePage = (isset($_GET["page"])) ? $_GET["page"] : 1;
$firstData = ($totalDataPerPage * $activePage) - $totalDataPerPage;
$query = mysqli_query($conn, "SELECT filename FROM images ORDER BY filename DESC LIMIT $firstData,$totalDataPerPage");
if (!$query) {
    die("Query failed!");
}
mysqli_close($conn);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>A&M Gallery</title>
    <link rel="apple-touch-icon" sizes="180x180" href="./apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="./favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="./favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
    <link rel="stylesheet" href="./style.css" />
</head>

<body>
    <h1>Our Memories</h1>
    <div class="gallery">
        <?php while ($row = mysqli_fetch_assoc($query)) { ?>
            <div class="gallery-item">
                <img src="./image/<?= $row['filename']; ?>" />
            </div>
        <?php }
        if ($activePage == $totalPage) {
            echo '<div class="gallery-item">
            <img src="./image/soon.png" />
        </div>';
        }
        ?>
    </div>
    <form class="page-form" method="GET">
        <input type="number" name="page" class="page-number" placeholder="Halaman..." required>
        <button type="submit" class="page-button">Gas</button>
    </form>
    <div class="pagination">
        <?php
        $next = $activePage + 1;
        $previous = $activePage - 1;
        if ($activePage == 1) {
            echo '<a href="?page=' . $next . '" class="page-button">Lanjut</a>';
        } elseif ($activePage == $totalPage) {
            echo '<a href="?page=' . $previous . '" class="page-button">Balik</a>';
        } else {
            echo '<a href="?page=' . $previous . '" class="page-button">Balik</a>';
            echo '<a href="?page=' . $next . '" class="page-button">Lanjut</a>';
        }
        ?>
    </div>
</body>

</html>