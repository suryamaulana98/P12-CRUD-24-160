<?php
include 'db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Ambil data dulu untuk tahu nama file gambarnya
    $sql = "SELECT gambar FROM books WHERE id = $id";
    $result = mysqli_query($conn, $sql);
    $book = mysqli_fetch_assoc($result);

    if ($book) {
        // Hapus file gambar
        $gambar_path = 'uploads/' . $book['gambar'];
        if (file_exists($gambar_path)) {
            unlink($gambar_path);
        }

        // Hapus data dari database
        $deleteSql = "DELETE FROM books WHERE id = $id";
        if (mysqli_query($conn, $deleteSql)) {
            header('Location: index.php');
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        echo "Data tidak ditemukan!";
    }
} else {
    echo "ID tidak ditemukan!";
}
