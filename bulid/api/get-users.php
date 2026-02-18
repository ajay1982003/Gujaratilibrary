<?php

require_once __DIR__ . '/../app/core/database.php';
require_once __DIR__ . '/../app/helpers/SessionHelper.php';
require_once __DIR__ . '/../app/controllers/UserController.php';


header('Content-Type: application/json');

$userController = new UserController();
$users = $userController->getAllUsers();

$data = [];
$sr_no = 1;
if (!empty($users)) {
    foreach ($users as $user) {
        $user['sr_no'] = $sr_no++;
        $data[] = [
            'sr_no' => $user['sr_no'],
            'name' => htmlspecialchars($user['name'] ?? 'N/A'),
            'email' => htmlspecialchars($user['email'] ?? 'N/A'),
            'password' => htmlspecialchars($user['password'] ?? 'N/A'),
            'id' => $user['id']
        ];
    }
}
echo json_encode(['data' => $data]);

?>