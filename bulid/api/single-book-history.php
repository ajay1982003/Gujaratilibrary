<?php
session_start();
require_once __DIR__ . '/../app/helpers/SessionHelper.php';
require_once __DIR__ . '/../app/controllers/BookingissueController.php';

header('Content-Type: application/json');

// Login check
if (!SessionHelper::isLoggedIn()) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

$bookingIssueController = new BookingissueController();

$bookId = isset($_GET['book_id']) ? intval($_GET['book_id']) : 0;

$issueHistory = $bookingIssueController->getIssueHistoryByBookId($bookId);

$data = [];
$sr_no = 1;

if (!empty($issueHistory)) {

    foreach ($issueHistory as $issue) {

        $status = $issue['status'] ?? 'available';

        // Simple readable status
        $badgeText = ($status === 'issued')
            ? 'Taken'
            : 'Available';

        $data[] = [
            'sr_no' => $sr_no++,
            'book_name' => htmlspecialchars($issue['book_name'] ?? ''),
            'issued_to' => htmlspecialchars($issue['issued_to'] ?? ''),
            'issued_to_contact' => htmlspecialchars($issue['issued_to_contact'] ?? ''),
            'issue_date' => htmlspecialchars($issue['issue_date'] ?? ''),
            'expected_return_date' => htmlspecialchars($issue['expected_return_date'] ?? ''),
            'actual_return_date' => htmlspecialchars($issue['actual_return_date'] ?? ''),
            'status' => $badgeText,
            'remark' => htmlspecialchars($issue['remark'] ?? '')
        ];
    }
}

echo json_encode([
    "data" => $data
]);

exit;
