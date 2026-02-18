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
        $shelf_norm = mb_strtolower($data['shelf_detail'], 'UTF-8');

        // Default values
        $available_status = 'available';

        $sql = "INSERT INTO books (
                    excel_iD, sr_no, categoryName, vishay, 
                    old_sub_id, new_sub_id, new_sub_id_2901, subject_name, 
                    naam, name1, name2, name3, name4, 
                    granthkar, granthkar_0811, 
                    punah_granthkar, punah_granthkar_0811, 
                    teekakar, teekakar_0811, 
                    anuvadak, anuvadak_0811, 
                    sampadak, sampadak_0811, 
                    punah_sampadak, punah_sampadak_0811, 
                    prakashak, prakashak_0811, 
                    purva_prakashak, purva_prakashak_0811, 
                    bhasha, pages, shelf_detail, remark, available_status,
                    naam_norm, granthkar_norm, subject_norm, prakashak_norm, shelf_norm
                ) VALUES (
                    :excel_iD, :sr_no, :categoryName, :vishay, 
                    :old_sub_id, :new_sub_id, :new_sub_id_2901, :subject_name, 
                    :naam, :name1, :name2, :name3, :name4, 
                    :granthkar, :granthkar_0811, 
                    :punah_granthkar, :punah_granthkar_0811, 
                    :teekakar, :teekakar_0811, 
                    :anuvadak, :anuvadak_0811, 
                    :sampadak, :sampadak_0811, 
                    :punah_sampadak, :punah_sampadak_0811, 
                    :prakashak, :prakashak_0811, 
                    :purva_prakashak, :purva_prakashak_0811, 
                    :bhasha, :pages, :shelf_detail, :remark, :available_status,
                    :naam_norm, :granthkar_norm, :subject_norm, :prakashak_norm, :shelf_norm
                )";

        $stmt = $this->db->prepare($sql);

        $stmt->bindValue(':excel_iD', $data['excel_iD']);
        $stmt->bindValue(':sr_no', $data['sr_no']);
        $stmt->bindValue(':categoryName', $data['categoryName']);
        $stmt->bindValue(':vishay', $data['vishay']);
        $stmt->bindValue(':old_sub_id', $data['old_sub_id']);
        $stmt->bindValue(':new_sub_id', $data['new_sub_id']);
        $stmt->bindValue(':new_sub_id_2901', $data['new_sub_id_2901']);
        $stmt->bindValue(':subject_name', $data['subject_name']);

        $stmt->bindValue(':naam', $data['naam']);
        $stmt->bindValue(':name1', $data['name1']);
        $stmt->bindValue(':name2', $data['name2']);
        $stmt->bindValue(':name3', $data['name3']);
        $stmt->bindValue(':name4', $data['name4']);

        $stmt->bindValue(':granthkar', $data['granthkar']);
        $stmt->bindValue(':granthkar_0811', $data['granthkar_0811']);
        $stmt->bindValue(':punah_granthkar', $data['punah_granthkar']);
        $stmt->bindValue(':punah_granthkar_0811', $data['punah_granthkar_0811']);
        $stmt->bindValue(':teekakar', $data['teekakar']);
        $stmt->bindValue(':teekakar_0811', $data['teekakar_0811']);
        $stmt->bindValue(':anuvadak', $data['anuvadak']);
        $stmt->bindValue(':anuvadak_0811', $data['anuvadak_0811']);
        $stmt->bindValue(':sampadak', $data['sampadak']);
        $stmt->bindValue(':sampadak_0811', $data['sampadak_0811']);
        $stmt->bindValue(':punah_sampadak', $data['punah_sampadak']);
        $stmt->bindValue(':punah_sampadak_0811', $data['punah_sampadak_0811']);

        $stmt->bindValue(':prakashak', $data['prakashak']);
        $stmt->bindValue(':prakashak_0811', $data['prakashak_0811']);
        $stmt->bindValue(':purva_prakashak', $data['purva_prakashak']);
        $stmt->bindValue(':purva_prakashak_0811', $data['purva_prakashak_0811']);

        $stmt->bindValue(':bhasha', $data['bhasha']);
        $stmt->bindValue(':pages', $data['pages']);
        $stmt->bindValue(':shelf_detail', $data['shelf_detail']);
        $stmt->bindValue(':remark', $data['remark']);
        $stmt->bindValue(':available_status', $available_status);

        $stmt->bindValue(':naam_norm', $naam_norm);
        $stmt->bindValue(':granthkar_norm', $granthkar_norm);
        $stmt->bindValue(':subject_norm', $subject_norm);
        $stmt->bindValue(':prakashak_norm', $prakashak_norm);
        $stmt->bindValue(':shelf_norm', $shelf_norm);

        return $stmt->execute();
    }

    public function updateBook($data)
    {
        // Normalize fields for search
        $naam_norm = mb_strtolower($data['naam'], 'UTF-8');
        $granthkar_norm = mb_strtolower($data['granthkar'], 'UTF-8');
        $subject_norm = mb_strtolower($data['subject_name'], 'UTF-8');
        $prakashak_norm = mb_strtolower($data['prakashak'], 'UTF-8');
        $shelf_norm = mb_strtolower($data['shelf_detail'], 'UTF-8');

        $data['id'] = $_GET['book_id'];

        $sql = "UPDATE books SET 
                    excel_iD = :excel_iD, sr_no = :sr_no, categoryName = :categoryName, vishay = :vishay, 
                    old_sub_id = :old_sub_id, new_sub_id = :new_sub_id, new_sub_id_2901 = :new_sub_id_2901, subject_name = :subject_name, 
                    naam = :naam, name1 = :name1, name2 = :name2, name3 = :name3, name4 = :name4, 
                    granthkar = :granthkar, granthkar_0811 = :granthkar_0811, 
                    punah_granthkar = :punah_granthkar, punah_granthkar_0811 = :punah_granthkar_0811, 
                    teekakar = :teekakar, teekakar_0811 = :teekakar_0811, 
                    anuvadak = :anuvadak, anuvadak_0811 = :anuvadak_0811, 
                    sampadak = :sampadak, sampadak_0811 = :sampadak_0811, 
                    punah_sampadak = :punah_sampadak, punah_sampadak_0811 = :punah_sampadak_0811, 
                    prakashak = :prakashak, prakashak_0811 = :prakashak_0811, 
                    purva_prakashak = :purva_prakashak, purva_prakashak_0811 = :purva_prakashak_0811, 
                    bhasha = :bhasha, pages = :pages, shelf_detail = :shelf_detail, remark = :remark, 
                    naam_norm = :naam_norm, granthkar_norm = :granthkar_norm, subject_norm = :subject_norm, prakashak_norm = :prakashak_norm, shelf_norm = :shelf_norm
                WHERE id = :id";

        $stmt = $this->db->prepare($sql);

        $stmt->bindValue(':excel_iD', $data['excel_iD']);
        $stmt->bindValue(':sr_no', $data['sr_no']);
        $stmt->bindValue(':categoryName', $data['categoryName']);
        $stmt->bindValue(':vishay', $data['vishay']);
        $stmt->bindValue(':old_sub_id', $data['old_sub_id']);
        $stmt->bindValue(':new_sub_id', $data['new_sub_id']);
        $stmt->bindValue(':new_sub_id_2901', $data['new_sub_id_2901']);
        $stmt->bindValue(':subject_name', $data['subject_name']);

        $stmt->bindValue(':naam', $data['naam']);
        $stmt->bindValue(':name1', $data['name1']);
        $stmt->bindValue(':name2', $data['name2']);
        $stmt->bindValue(':name3', $data['name3']);
        $stmt->bindValue(':name4', $data['name4']);

        $stmt->bindValue(':granthkar', $data['granthkar']);
        $stmt->bindValue(':granthkar_0811', $data['granthkar_0811']);
        $stmt->bindValue(':punah_granthkar', $data['punah_granthkar']);
        $stmt->bindValue(':punah_granthkar_0811', $data['punah_granthkar_0811']);
        $stmt->bindValue(':teekakar', $data['teekakar']);
        $stmt->bindValue(':teekakar_0811', $data['teekakar_0811']);
        $stmt->bindValue(':anuvadak', $data['anuvadak']);
        $stmt->bindValue(':anuvadak_0811', $data['anuvadak_0811']);
        $stmt->bindValue(':sampadak', $data['sampadak']);
        $stmt->bindValue(':sampadak_0811', $data['sampadak_0811']);
        $stmt->bindValue(':punah_sampadak', $data['punah_sampadak']);
        $stmt->bindValue(':punah_sampadak_0811', $data['punah_sampadak_0811']);

        $stmt->bindValue(':prakashak', $data['prakashak']);
        $stmt->bindValue(':prakashak_0811', $data['prakashak_0811']);
        $stmt->bindValue(':purva_prakashak', $data['purva_prakashak']);
        $stmt->bindValue(':purva_prakashak_0811', $data['purva_prakashak_0811']);

        $stmt->bindValue(':bhasha', $data['bhasha']);
        $stmt->bindValue(':pages', $data['pages']);
        $stmt->bindValue(':shelf_detail', $data['shelf_detail']);
        $stmt->bindValue(':remark', $data['remark']);

        $stmt->bindValue(':naam_norm', $naam_norm);
        $stmt->bindValue(':granthkar_norm', $granthkar_norm);
        $stmt->bindValue(':subject_norm', $subject_norm);
        $stmt->bindValue(':prakashak_norm', $prakashak_norm);
        $stmt->bindValue(':shelf_norm', $shelf_norm);

        $stmt->bindValue(':id', $data['id']);

        return $stmt->execute();
    }

    public function deleteBook($id)
    {
        $sql = "DELETE FROM books WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $id);
        return $stmt->execute();
    }
}

?>