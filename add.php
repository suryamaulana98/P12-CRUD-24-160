<?php
include 'db.php';

if (isset($_POST['submit'])) {
    $judul = $_POST['judul'];
    $pengarang = $_POST['pengarang'];
    $tahun_terbit = $_POST['tahun_terbit'];

    $gambar = $_FILES['gambar']['name'];
    $target = 'uploads/' . basename($gambar);

    if (move_uploaded_file($_FILES['gambar']['tmp_name'], $target)) {
        $sql = "INSERT INTO books (judul, pengarang, tahun_terbit, gambar) VALUES ('$judul', '$pengarang', '$tahun_terbit', '$gambar')";
        if (mysqli_query($conn, $sql)) {
            header('Location: index.php');
        } else {
            echo 'Error: ' . mysqli_error($conn);
        }
    } else {
        echo 'File upload failed!';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Tambah Buku</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <h1 >Tambah Buku</h1>
    <form method='POST' enctype='multipart/form-data'>
        Judul: <input type='text' name='judul' required><br>
        Pengarang: <input type='text' name="pengarang" required><br>
        Tahun Terbit: <input type='date' name="tahun_terbit" required><br>
        Gambar Buku: <input type='file' name='gambar' required><br>
        <button type='submit' name='submit'>Save</button>
    </form>


</body>

</html>