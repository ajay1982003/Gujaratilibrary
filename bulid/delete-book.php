<?php
require_once __DIR__ . '/app/controllers/BookController.php';

$bookController = new BookController();

if (isset($_GET['book_id'])) {
    $book_id = $_GET['book_id'];
    $result = $bookController->deleteBook($book_id);
    if ($result) {
        header('Location: books.php');
    }
    else {
        echo "<script>alert('Failed to delete book');</script>";
    }
}
?>