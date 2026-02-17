<?php

require_once __DIR__ . '/../app/helpers/SessionHelper.php';
require_once __DIR__ . '/../app/controllers/BookingissueController.php';

header('Content-Type: application/json');
// Check if user is logged in
if (!SessionHelper::isLoggedIn()) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized']);
    exit();
}

$bookingIssueController = new BookingissueController();
$issueHistory = $bookingIssueController->getIssueHistory();

$data = [];
$sr_no = 1;
if (!empty($issueHistory)) {
    foreach ($issueHistory as $issue) {
        $issue['sr_no'] = $sr_no++;
        $status = $issue['status'] ?? 'returned';
        $badgeClass = ($status === 'issued') ? 'bg-label-warning' : 'bg-label-success';
        $badgeText = ($status === 'issued') ? 'Issued' : 'Returned';
        $data[] = [
            'book_id' => $issue['book_id'] ?? 'N/A',
            'book_name' => htmlspecialchars($issue['book_name'] ?? 'N/A'),
            'issued_to' => htmlspecialchars($issue['issued_to'] ?? 'N/A'),
            'issued_to_contact' => htmlspecialchars($issue['issued_to_contact'] ?? 'N/A'),
            'issue_date' => htmlspecialchars($issue['issue_date'] ?? 'N/A'),
            'return_date' => htmlspecialchars($issue['actual_return_date'] ?? 'N/A'),
            'status' => $badgeText,
            'status_class' => $badgeClass,
            'sr_no' => $issue['sr_no']
        ];
    }
}
echo json_encode(['data' => $data]);

?>