<?php
include "db.php";

// Search
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Pagination setup
$limit = 4;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$start = ($page - 1) * $limit;

// Count total records
$countSql = "SELECT COUNT(*) AS total FROM books WHERE judul LIKE '%$search%'";
$countResult = mysqli_query($conn, $countSql);
$countRow = mysqli_fetch_assoc($countResult);
$total = $countRow['total'];
$pages = ceil($total / $limit);

// Fetch records
$sql = "SELECT * FROM books WHERE judul LIKE '%$search%' LIMIT $start, $limit";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Index</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <form method='GET'>
        <input type='text' name='search' placeholder='Search by name...' value='<?php echo $search; ?>'>
        <button type='submit'>Search</button>
    </form>

    <a href='add.php'>+ Add New Product</a>

    <table border='1' cellpadding='10'>
        <tr>
            <th>ID</th>
            <th>Judul</th>
            <th>Pengarang</th>
            <th>Tahun Terbit</th>
            <th>Gambar</th>
            <th>Action</th>
        </tr>

        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['judul']; ?></td>
                <td><?php echo $row['pengarang']; ?></td>
                <td><?php echo $row['tahun_terbit']; ?></td>
                <td><img src='uploads/<?php echo $row['gambar']; ?>' width='80'></td>
                <td>
                    <a href='edit.php?id=<?php echo $row['id']; ?>'>Edit</a> |
                    <a href='delete.php?id=<?php echo $row['id']; ?>'>Delete</a>
                </td>
            </tr>
        <?php } ?>
    </table>

    <?php for ($i = 1; $i <= $pages; $i++) { ?>
        <a href='?page=<?php echo $i; ?>&search=<?php echo $search; ?>'><?php echo $i; ?></a>
    <?php }

    ?>


</body>

</html>