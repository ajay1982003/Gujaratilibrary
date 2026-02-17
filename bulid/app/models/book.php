<?php

require_once __DIR__ . '/../core/database.php';

class book
{
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->connect();
    }

    public function getAllbooks()
    {
        $stmt = $this->db->query("SELECT * from books");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function getBooksPaginated($limit = 10, $offset = 0)
    {
        $stmt = $this->db->prepare("SELECT * FROM books LIMIT :limit OFFSET :offset");
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTotalBooks()
    {
        $stmt = $this->db->query("SELECT COUNT(*) as total FROM books");
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'];
    }

    public function getissuedtotalbooks()
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) as total FROM books WHERE available_status='issued'");
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'];
    }

    public function getissuedBooks()
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) as total FROM books WHERE available_status='issued'");
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
        ;
    }

    public function getavailableBooks()
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) as total FROM books WHERE available_status='available'");
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'];
    }

    public function searchBooks($search, $limit = 10, $offset = 0)
    {
        $searchTerm = '%' . $search . '%';
        $sql = "SELECT * FROM books WHERE 
                naam LIKE :search OR 
                naam_norm LIKE :search_norm OR 
                name1 LIKE :search OR 
                granthkar LIKE :search OR 
                granthkar_norm LIKE :search_norm OR 
                subject_name LIKE :search OR 
                subject_norm LIKE :search_norm OR 
                prakashak LIKE :search OR 
                prakashak_norm LIKE :search_norm OR 
                bhasha LIKE :search OR 
                categoryName LIKE :search
                LIMIT :limit OFFSET :offset";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':search', $searchTerm, PDO::PARAM_STR);
        $stmt->bindValue(':search_norm', mb_strtolower($search, 'UTF-8') . '%', PDO::PARAM_STR);
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function searchBooksCount($search)
    {
        $searchTerm = '%' . $search . '%';
        $sql = "SELECT COUNT(*) as total FROM books WHERE 
                naam LIKE :search OR 
                naam_norm LIKE :search_norm OR 
                name1 LIKE :search OR 
                granthkar LIKE :search OR 
                granthkar_norm LIKE :search_norm OR 
                subject_name LIKE :search OR 
                subject_norm LIKE :search_norm OR 
                prakashak LIKE :search OR 
                prakashak_norm LIKE :search_norm OR 
                bhasha LIKE :search OR 
                categoryName LIKE :search";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':search', $searchTerm, PDO::PARAM_STR);
        $stmt->bindValue(':search_norm', mb_strtolower($search, 'UTF-8') . '%', PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'];
    }


    public function getbookbyid($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM books WHERE id = :id");
        $stmt->bindValue(':id', (int)$id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function addBook($data)
    {
        // Normalize fields for search
        $naam_norm = mb_strtolower($data['naam'], 'UTF-8');
        $granthkar_norm = mb_strtolower($data['granthkar'], 'UTF-8');
        $subject_norm = mb_strtolower($data['subject_name'], 'UTF-8');
        $prakashak_norm = mb_strtolower($data['prakashak'], 'UTF-8');

        // Default values
        $available_status = 'available';

        $sql = "INSERT INTO books (
                    naam, naam_norm, 
                    granthkar, granthkar_norm, 
                    subject_name, subject_norm, 
                    prakashak, prakashak_norm, 
                    bhasha, pages, categoryName, 
                    available_status
                ) VALUES (
                    :naam, :naam_norm, 
                    :granthkar, :granthkar_norm, 
                    :subject_name, :subject_norm, 
                    :prakashak, :prakashak_norm, 
                    :bhasha, :pages, :categoryName, 
                    :available_status
                )";

        $stmt = $this->db->prepare($sql);

        $stmt->bindValue(':naam', $data['naam']);
        $stmt->bindValue(':naam_norm', $naam_norm);
        $stmt->bindValue(':granthkar', $data['granthkar']);
        $stmt->bindValue(':granthkar_norm', $granthkar_norm);
        $stmt->bindValue(':subject_name', $data['subject_name']);
        $stmt->bindValue(':subject_norm', $subject_norm);
        $stmt->bindValue(':prakashak', $data['prakashak']);
        $stmt->bindValue(':prakashak_norm', $prakashak_norm);
        $stmt->bindValue(':bhasha', $data['bhasha']);
        $stmt->bindValue(':pages', $data['pages']);
        $stmt->bindValue(':categoryName', $data['categoryName']);
        $stmt->bindValue(':available_status', $available_status);

        return $stmt->execute();
    }
}

?>