<?php
require_once __DIR__ . '/../core/database.php';
require_once __DIR__ . '/../models/Bookissue.php';
class BookingissueController
{
    private $bookingIssueModel;

    public function __construct()
    {
        $this->bookingIssueModel = new BookIssue();

    }
    public function issueBook($book_id, $issued_to, $issued_to_contact, $expected_return_date = null, $remark = '')
    {
        return $this->bookingIssueModel->issueBook($book_id, $issued_to, $issued_to_contact, $expected_return_date, $remark);
    }

    public function updateBookStatus($book_id, $status)
    {
        return $this->bookingIssueModel->updateBookStatus($book_id, $status);
    }

    public function getIssueHistory($book_id = null)
    {
        return $this->bookingIssueModel->getIssueHistory($book_id);
    }

    public function getAllIssueHistory()
    {
        return $this->bookingIssueModel->getIssueHistory();
    }
    
    public function returnBook($issue_id)
    {
       return $this->bookingIssueModel->updateBookStatus($issue_id, 'available');
    }
    
}

?>