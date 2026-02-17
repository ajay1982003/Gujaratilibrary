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

$controller = new BookController();
$bookModel = new book();

// DataTable parameters
$draw = isset($_GET['draw']) ? intval($_GET['draw']) : 1;
$start = isset($_GET['start']) ? intval($_GET['start']) : 0;
$length = isset($_GET['length']) ? intval($_GET['length']) : 10;
$search_value = isset($_GET['search']['value']) ? trim($_GET['search']['value']) : '';

$items_per_page = $length;
$page = ($start / $length) + 1;

// Get paginated and filtered books
if (!empty($search_value)) {
    $books = $bookModel->searchBooks($search_value, $items_per_page, $start);
    $total_books = $bookModel->searchBooksCount($search_value);
} else {
    $books = $controller->getBooksPaginated($page, $items_per_page);
    $total_books = $controller->getTotalBooks();
}

$offset = $start;
$sr_no = $offset + 1;

// Build DataTable-compatible data array
$data = [];
if (!empty($books)) {
    foreach ($books as $book) {
        $status = $book['available_status'] ?? 'available';
        $badgeClass = ($status === 'issued') ? 'bg-label-warning' : 'bg-label-success';
        $badgeText = ($status === 'issued') ? 'Issued' : 'Available';
        
        $data[] = [
            'sr_no' => $sr_no,
            'id' => $book['id'],
            'naam' => htmlspecialchars($book['naam'] ?? $book['name'] ?? 'N/A'),
            'granthkar' => htmlspecialchars($book['granthkar'] ?? 'N/A'),
            'subject_name' => htmlspecialchars($book['subject_name'] ?? 'N/A'),
            'prakashak' => htmlspecialchars($book['prakashak_0811'] ?? 'N/A'),
            'bhasha' => htmlspecialchars($book['bhasha'] ?? 'N/A'),
            'pages' => $book['pages'] ?? 'N/A',
            'category' => htmlspecialchars($book['categoryName'] ?? 'N/A'),
            'status' => $badgeText,
            'status_class' => $badgeClass,
            'available_status' => $status
        ];
        
        $sr_no++;
    }
}

// Return DataTables-compatible JSON response
echo json_encode([
    'draw' => $draw,
    'recordsTotal' => $total_books,
    'recordsFiltered' => $total_books,
    'data' => $data,
    'search' => $search_value
]);
?>
