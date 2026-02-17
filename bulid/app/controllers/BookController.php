<?php
require_once __DIR__ . '/../core/database.php';
require_once __DIR__ . '/../models/book.php';

class BookController
{
    private $bookModel;

    public function __construct()
    {
        $this->bookModel = new book();
    }

    public function getAllBooks()
    {
        return $this->bookModel->getAllbooks();
    }

    public function getBookById($id)
    {
        return $this->bookModel->getbookbyid($id);
      
        return null; // Return null if book not found
    }

    public function getBooksPaginated($page = 1, $limit = 10)
    {
        $offset = ($page - 1) * $limit;
        return $this->bookModel->getBooksPaginated($limit, $offset);
    }

    public function getTotalBooks()
    {
        return $this->bookModel->getTotalBooks();
    }

    public function getissuedtotalbooks()
    {
        return $this->bookModel->getissuedtotalbooks();
    }

    public function getavailableBooks()
    {
        return $this->bookModel->getavailableBooks();
    }

 
}
?>
