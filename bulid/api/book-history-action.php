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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = isset($_POST['action']) ? trim($_POST['action']) : null;
    $record_id = isset($_POST['record_id']) ? intval($_POST['record_id']) : null;

    if (!$action || !$record_id) {
        echo json_encode([
            'success' => false,
            'message' => 'Action and Record ID are required'
        ]);
        exit;
    }

    try {
        $db = (new Database())->connect();
        
        if ($action === 'mark_returned') {
            // Get issue record to find book_id
            $sql = "SELECT book_id FROM book_issue WHERE id = :id";
            $stmt = $db->prepare($sql);
            $stmt->bindValue(':id', $record_id, PDO::PARAM_INT);
            $stmt->execute();
            $record = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($record) {
                $book_id = $record['book_id'];
                
                // Update book_issue table
                $updateSql = "UPDATE book_issue SET actual_return_date = NOW(), status = 'returned' WHERE id = :id";
                $updateStmt = $db->prepare($updateSql);
                $updateStmt->bindValue(':id', $record_id, PDO::PARAM_INT);
                $updateResult = $updateStmt->execute();

                // Update books table to available
                $updateBookSql = "UPDATE books SET available_status = 'available' WHERE id = :book_id";
                $updateBookStmt = $db->prepare($updateBookSql);
                $updateBookStmt->bindValue(':book_id', $book_id, PDO::PARAM_INT);
                $updateBookStmt->execute();

                echo json_encode([
                    'success' => true,
                    'message' => 'Book marked as returned successfully'
                ]);
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'Record not found'
                ]);
            }
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Invalid action'
            ]);
        }
    } catch (Exception $e) {
        echo json_encode([
            'success' => false,
            'message' => 'Error: ' . $e->getMessage()
        ]);
    }
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Only POST method is allowed'
    ]);
}
?>

