<?php
session_start();
require_once __DIR__ . '/../app/core/database.php';
require_once __DIR__ . '/../app/models/BookIssue.php';
require_once __DIR__ . '/../app/helpers/SessionHelper.php';

header('Content-Type: application/json');

// Check if user is logged in
if (!SessionHelper::isLoggedIn()) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Unauthorized access']);
    exit();
}

$bookIssue = new BookIssue();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $book_id = isset($_POST['book_id']) ? intval($_POST['book_id']) : null;
    $status = isset($_POST['status']) ? trim($_POST['status']) : null;
    $issued_to = isset($_POST['issued_to']) ? trim($_POST['issued_to']) : null;
    $issued_to_contact = isset($_POST['issued_to_contact']) ? trim($_POST['issued_to_contact']) : null;

    // Validate inputs
    if (!$book_id || !$status) {
        echo json_encode([
            'success' => false,
            'message' => 'Book ID and Status are required'
        ]);
        exit;
    }

    // Valid status values
    $valid_statuses = ['available', 'issued'];
    if (!in_array($status, $valid_statuses)) {
        echo json_encode([
            'success' => false,
            'message' => 'Invalid status value'
        ]);
        exit;
    }

    try {
        $db = (new Database())->connect();

        // Update book status
        $result = $bookIssue->updateBookStatus($book_id, $status);

        if ($result) {
            // If status is 'issued', also add to book_issue table
            if ($status === 'issued') {
                $issued_to_email = isset($_POST['issued_to_email']) ? trim($_POST['issued_to_email']) : null;
                $issue_date = isset($_POST['issue_date']) ? trim($_POST['issue_date']) : null;

                if (!$issued_to || !$issued_to_contact) {
                    echo json_encode([
                        'success' => false,
                        'message' => 'Name and Phone number are required for issued status'
                    ]);
                    exit;
                }

                $issue_result = $bookIssue->issueBook($book_id, $issued_to, $issued_to_contact, $issued_to_email, $issue_date);

                if ($issue_result) {
                    echo json_encode([
                        'success' => true,
                        'message' => 'Book issued successfully'
                    ]);
                }
                else {
                    echo json_encode([
                        'success' => false,
                        'message' => 'Book status updated but failed to create issue record'
                    ]);
                }
            }
            else if ($status === 'available') {
                $return_date = isset($_POST['return_date']) ? trim($_POST['return_date']) : null;

                // Use the model method to return the book
                $result = $bookIssue->returnBook($book_id, $return_date);

                echo json_encode([
                    'success' => true,
                    'message' => 'Book marked as available and returned record updated'
                ]);
            }
            else {
                echo json_encode([
                    'success' => true,
                    'message' => 'Book status updated successfully'
                ]);
            }
        }
        else {
            echo json_encode([
                'success' => false,
                'message' => 'Failed to update book status'
            ]);
        }
    }
    catch (Exception $e) {
        echo json_encode([
            'success' => false,
            'message' => 'Error: ' . $e->getMessage()
        ]);
    }
}
else {
    echo json_encode([
        'success' => false,
        'message' => 'Only POST method is allowed'
    ]);
}
?>
