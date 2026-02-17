<?php
session_start();
require_once __DIR__ . '/../app/core/database.php';
require_once __DIR__ . '/../app/models/book.php';
require_once __DIR__ . '/../app/controllers/BookController.php';
require_once __DIR__ . '/../app/helpers/SessionHelper.php';

header('Content-Type: application/json');

// Check if user is logged in
if (!SessionHelper::isLoggedIn()) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized']);
    exit();
}

try {
    $controller = new BookController();
    $books = $controller->getAllBooks();
    
    echo json_encode([
        'success' => true,
        'count' => count($books),
        'books' => $books
    ]);
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}

?>
