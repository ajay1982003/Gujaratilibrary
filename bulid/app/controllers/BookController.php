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

    public function addBook($data)
    {
        // Define all expected fields with default empty string or null
        $defaults = [
            'excel_iD' => null, 'sr_no' => null, 'categoryName' => null,
            'vishay' => null, 'old_sub_id' => null, 'new_sub_id' => null, 'new_sub_id_2901' => null,
            'subject_name' => '', 'naam' => '', 'name1' => null, 'name2' => null, 'name3' => null, 'name4' => null,
            'granthkar' => '', 'granthkar_0811' => null,
            'punah_granthkar' => null, 'punah_granthkar_0811' => null,
            'teekakar' => null, 'teekakar_0811' => null,
            'anuvadak' => null, 'anuvadak_0811' => null,
            'sampadak' => null, 'sampadak_0811' => null,
            'punah_sampadak' => null, 'punah_sampadak_0811' => null,
            'prakashak' => '', 'prakashak_0811' => null,
            'purva_prakashak' => null, 'purva_prakashak_0811' => null,
            'bhasha' => null, 'pages' => 0, 'shelf_detail' => '', 'remark' => null
        ];

        // Merge defaults with provided data
        $bookData = array_merge($defaults, array_intersect_key($data, $defaults));

        // Basic validation for required fields
        if (empty($bookData['naam'])) {
            return ['success' => false, 'message' => 'Book Name (Naam) is required'];
        }

        if ($this->bookModel->addBook($bookData)) {
            return ['success' => true, 'message' => 'Book added successfully'];
        }
        else {
            return ['success' => false, 'message' => 'Failed to add book'];
        }
    }

    public function updateBook($data)
    {
        $defaults = [
            'excel_iD' => null, 'sr_no' => null, 'categoryName' => null,
            'vishay' => null, 'old_sub_id' => null, 'new_sub_id' => null, 'new_sub_id_2901' => null,
            'subject_name' => '', 'naam' => '', 'name1' => null, 'name2' => null, 'name3' => null, 'name4' => null,
            'granthkar' => '', 'granthkar_0811' => null,
            'punah_granthkar' => null, 'punah_granthkar_0811' => null,
            'teekakar' => null, 'teekakar_0811' => null,
            'anuvadak' => null, 'anuvadak_0811' => null,
            'sampadak' => null, 'sampadak_0811' => null,
            'punah_sampadak' => null, 'punah_sampadak_0811' => null,
            'prakashak' => '', 'prakashak_0811' => null,
            'purva_prakashak' => null, 'purva_prakashak_0811' => null,
            'bhasha' => null, 'pages' => 0, 'shelf_detail' => '', 'remark' => null
        ];

        // Merge defaults with provided data
        $bookData = array_merge($defaults, array_intersect_key($data, $defaults));

        // Basic validation for required fields
        if (empty($bookData['naam'])) {
            return ['success' => false, 'message' => 'Book Name (Naam) is required'];
        }

        if ($this->bookModel->updateBook($bookData)) {
            return ['success' => true, 'message' => 'Book updated successfully'];
        }
        else {
            return ['success' => false, 'message' => 'Failed to update book'];
        }
    }

    public function deleteBook($id)
    {
        return $this->bookModel->deleteBook($id);
    }
}
?>
