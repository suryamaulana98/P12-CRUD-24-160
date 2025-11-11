<?php
include 'db.php';

// Ambil data buku berdasarkan ID
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM books WHERE id = $id";
    $result = mysqli_query($conn, $sql);
    $book = mysqli_fetch_assoc($result);

    if (!$book) {
        die("Data tidak ditemukan!");
    }
}

if (isset($_POST['submit'])) {
    $judul = $_POST['judul'];
    $pengarang = $_POST['pengarang'];
    $tahun_terbit = $_POST['tahun_terbit'];

    // Cek apakah user mengganti gambar
    if (!empty($_FILES['gambar']['name'])) {
        $gambar = $_FILES['gambar']['name'];
        $target = 'uploads/' . basename($gambar);

        // Hapus gambar lama
        if (file_exists('uploads/' . $book['gambar'])) {
            unlink('uploads/' . $book['gambar']);
        }

        // Upload gambar baru
        if (move_uploaded_file($_FILES['gambar']['tmp_name'], $target)) {
            $sql = "UPDATE books 
                    SET judul='$judul', pengarang='$pengarang', tahun_terbit='$tahun_terbit', gambar='$gambar' 
                    WHERE id=$id";
        } else {
            echo "Upload gambar baru gagal!";
            exit;
        }
    } else {
        // Jika tidak mengganti gambar
        $sql = "UPDATE books 
                SET judul='$judul', pengarang='$pengarang', tahun_terbit='$tahun_terbit' 
                WHERE id=$id";
    }

    if (mysqli_query($conn, $sql)) {
        header('Location: index.php');
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Edit Buku</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <h1>Edit Data Buku</h1>
    <form method="POST" enctype="multipart/form-data">
        Judul: <input type="text" name="judul" value="<?php echo $book['judul']; ?>" required><br>
        Pengarang: <input type="text" name="pengarang" value="<?php echo $book['pengarang']; ?>" required><br>
        Tahun Terbit: <input type="date" name="tahun_terbit" value="<?php echo $book['tahun_terbit']; ?>" required><br>
        Gambar Lama: <br>
        <img src="uploads/<?php echo $book['gambar']; ?>" width="100"><br><br>
        Gambar Baru (opsional): <input type="file" name="gambar"><br><br>
        <button type="submit" name="submit">Update</button>
    </form>

</body>

</html>