<?php
session_start();
require_once __DIR__ . '/../app/core/database.php';
require_once __DIR__ . '/../app/models/book.php';
require_once __DIR__ . '/../app/models/BookIssue.php';
require_once __DIR__ . '/../app/helpers/SessionHelper.php';

header('Content-Type: application/json');

// Check if user is logged in
if (!SessionHelper::isLoggedIn()) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Unauthorized access']);
    exit();
}

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'POST') {
    $book_id = isset($_POST['book_id']) ? intval($_POST['book_id']) : 0;
    $issued_to = isset($_POST['issued_to']) ? trim($_POST['issued_to']) : '';
    $issued_to_contact = isset($_POST['issued_to_contact']) ? trim($_POST['issued_to_contact']) : '';
    $expected_return_date = isset($_POST['expected_return_date']) ? trim($_POST['expected_return_date']) : '';
    $remark = isset($_POST['remark']) ? trim($_POST['remark']) : '';

    // Validation
    if (!$book_id || !$issued_to || !$issued_to_contact) {
        echo json_encode([
            'success' => false,
            'message' => 'Please fill in all required fields (Book, Name, Contact)'
        ]);
        exit;
    }

    if (!$expected_return_date) {
        echo json_encode([
            'success' => false,
            'message' => 'Expected return date is required'
        ]);
        exit;
    }

    try {
        $bookIssueModel = new BookIssue();
        $bookModel = new book();

        // Prepare data for book_issue table
        $issue_data = [
            'book_id' => $book_id,
            'issued_to' => $issued_to,
            'issued_to_contact' => $issued_to_contact,
            'issue_date' => date('Y-m-d H:i:s'),
            'expected_return_date' => $expected_return_date,
            'status' => 'issued',
            'remark' => $remark,
            'created_at' => date('Y-m-d H:i:s')
        ];

        // Insert into book_issue table
        $bookIssueModel->issueBook($book_id, $issued_to, $issued_to_contact, $expected_return_date, $remark);

        // Update book status to issued
        $db = (new Database())->connect();
        $update_sql = "UPDATE books SET available_status = 'issued' WHERE id = :book_id";
        $stmt = $db->prepare($update_sql);
        $stmt->bindValue(':book_id', $book_id, PDO::PARAM_INT);
        $stmt->execute();

        echo json_encode([
            'success' => true,
            'message' => 'Book issued successfully'
        ]);
    } catch (Exception $e) {
        echo json_encode([
            'success' => false,
            'message' => 'Error issuing book: ' . $e->getMessage()
        ]);
    }
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid request method'
    ]);
}
?>
