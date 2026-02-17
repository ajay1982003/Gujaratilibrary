<?php

require_once __DIR__ . '/../core/database.php';

class BookIssue
{
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->connect();
    }

    public function issueBook($book_id, $issued_to, $issued_to_contact, $issue_to_email, $issue_date, $expected_return_date = null, $remark = '')
    {
        $sql = "INSERT INTO book_issue (book_id, issued_to, issued_to_contact, issue_to_email, issue_date, expected_return_date, status, remark, created_at)
                VALUES (:book_id, :issued_to, :issued_to_contact, :issue_to_email, :issue_date, :expected_return_date, :status, :remark, :created_at)";

        $stmt = $this->db->prepare($sql);

        $currentDate = date('Y-m-d H:i:s');
        // Use provided issue_date or default to current date
        $issueDate = $issue_date ? date('Y-m-d H:i:s', strtotime($issue_date)) : $currentDate;

        // Calculate return date based on issue date + 14 days
        $expectedReturnDate = $expected_return_date ?? date('Y-m-d', strtotime($issueDate . ' +14 days'));

        $stmt->bindValue(':book_id', (int)$book_id, PDO::PARAM_INT);
        $stmt->bindValue(':issued_to', $issued_to, PDO::PARAM_STR);
        $stmt->bindValue(':issued_to_contact', $issued_to_contact, PDO::PARAM_STR);
        $stmt->bindValue(':issue_to_email', $issue_to_email, PDO::PARAM_STR);
        $stmt->bindValue(':issue_date', $issueDate, PDO::PARAM_STR);
        $stmt->bindValue(':expected_return_date', $expectedReturnDate, PDO::PARAM_STR);
        $stmt->bindValue(':status', 'issued', PDO::PARAM_STR);
        $stmt->bindValue(':remark', $remark, PDO::PARAM_STR);
        $stmt->bindValue(':created_at', $currentDate, PDO::PARAM_STR);

        return $stmt->execute();
    }

    public function updateBookStatus($book_id, $status)
    {
        $sql = "UPDATE books SET available_status = :status WHERE id = :book_id";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':status', $status, PDO::PARAM_STR);
        $stmt->bindValue(':book_id', (int)$book_id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function getIssueHistory($book_id = null)
    {
        if ($book_id) {
            $sql = "SELECT bi.*, b.naam as book_name FROM book_issue bi 
                    LEFT JOIN books b ON bi.book_id = b.id 
                    WHERE bi.book_id = :book_id ORDER BY bi.issue_date DESC";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':book_id', $book_id, PDO::PARAM_INT);
            $stmt->execute();
        }
        else {
            $sql = "SELECT bi.*, b.naam as book_name FROM book_issue bi 
                    LEFT JOIN books b ON bi.book_id = b.id 
                    ORDER BY bi.issue_date DESC";
            $stmt = $this->db->query($sql);
        }
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getIssuedBooks()
    {
        $sql = "SELECT bi.*, b.naam as book_name FROM book_issue bi 
                LEFT JOIN books b ON bi.book_id = b.id 
                WHERE bi.status = 'issued' AND bi.actual_return_date IS NULL
                ORDER BY bi.issue_date DESC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function returnBook($book_id, $return_date = null)
    {
        $sql = "UPDATE book_issue SET actual_return_date = :return_date, status = 'returned' 
                WHERE book_id = :book_id AND status = 'issued'";

        $stmt = $this->db->prepare($sql);

        // Use provided return_date or current date/time
        $returnDate = $return_date ? date('Y-m-d H:i:s', strtotime($return_date)) : date('Y-m-d H:i:s');

        $stmt->bindValue(':return_date', $returnDate, PDO::PARAM_STR);
        $stmt->bindValue(':book_id', (int)$book_id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function singleIssueHistory($book_id)
    {
        $sql = "SELECT bi.*, b.naam AS book_name
            FROM book_issue bi
            LEFT JOIN books b ON bi.book_id = b.id
            WHERE bi.book_id = ?
            ORDER BY bi.issue_date DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$book_id]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}
?>
