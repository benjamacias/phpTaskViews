<?php
session_start();
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Task.php';
require_once __DIR__ . '/../models/SalaryRecord.php';
require_once __DIR__ . '/../models/Tag.php';

if(!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin'){
    header("Location: ../views/login.php");
    exit;
}

$db = (new Database())->getConnection();
$user = new User($db);
$taskModel = new Task($db);
$salaryRecord = new SalaryRecord($db);
$tagModel = new Tag($db);

$action = $_GET['action'] ?? 'list';

switch ($action) {
    case 'create':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user->name = $_POST['name'];
            $user->email = $_POST['email'];
            $user->password = $_POST['password'];
            $user->role = $_POST['role'];
            $user->hourly_rate = $_POST['hourly_rate'];
            $user->create();
            header("Location: AdminController.php?action=list");
            exit;
        }
        include __DIR__ . '/../views/admin/users/create.php';
        break;

    case 'tags':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $tagModel->name = $_POST['name'];
            $tagModel->operation = $_POST['operation'];
            $tagModel->mode = $_POST['mode'];
            $tagModel->amount = $_POST['amount'];
            $tagModel->auto_remove = isset($_POST['auto_remove']) ? 1 : 0;
            if (!empty($_POST['id'])) {
                $tagModel->id = $_POST['id'];
                $tagModel->update();
            } else {
                $tagModel->create();
            }
            header("Location: AdminController.php?action=tags");
            exit;
        }
        if (isset($_GET['deactivate'])) {
            $tagModel->id = $_GET['deactivate'];
            $tagModel->deactivate();
            header("Location: AdminController.php?action=tags");
            exit;
        }
        $editTag = null;
        if (isset($_GET['edit'])) {
            $editTag = $tagModel->getById($_GET['edit']);
        }
        $tags = $tagModel->readAll();
        include __DIR__ . '/../views/admin/tags/index.php';
        break;

    case 'user_tags':
        $userId = $_GET['user_id'] ?? null;
        if (!$userId) {
            header("Location: AdminController.php?action=list");
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userId = $_POST['user_id'];
            $selected = $_POST['tags'] ?? [];
            $tagModel->clearUserTags($userId);
            foreach ($selected as $tagId) {
                $tagModel->assignToUser($userId, $tagId);
            }
            header("Location: AdminController.php?action=user_tags&user_id=" . $userId);
            exit;
        }
        $assigned = $tagModel->getTagsByUser($userId);
        $assignedIds = array_map(fn($t) => $t['id'], $assigned);
        $tags = $tagModel->readAll();
        include __DIR__ . '/../views/admin/users/tags.php';
        break;

    case 'salary':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user->id = $_POST['user_id'];
            $user->hourly_rate = $_POST['hourly_rate'];
            $user->updateHourlyRate();

            $retirement = (float)$_POST['retirement'];
            $social = (float)$_POST['social_security'];
            $union = (float)$_POST['union_fee'];

            $hours = $taskModel->sumHoursByUser($user->id);
            $gross = $hours * $user->hourly_rate;
            $ret = $gross * ($retirement / 100);
            $soc = $gross * ($social / 100);
            $uni = $gross * ($union / 100);
            $net = $gross - $ret - $soc - $uni;

            $userTags = $tagModel->getTagsByUser($user->id);
            foreach ($userTags as $t) {
                $tagAmount = $t['mode'] === 'percent' ? ($gross * ((float)$t['amount'] / 100)) : (float)$t['amount'];
                if ($t['operation'] === 'deduction') {
                    $net -= $tagAmount;
                } else {
                    $net += $tagAmount;
                }
                if ($t['auto_remove']) {
                    $tagModel->removeFromUser($user->id, $t['id']);
                }
            }

            $salaryRecord->user_id = $user->id;
            $salaryRecord->month = date('Y-m');
            $salaryRecord->gross_salary = $gross;
            $salaryRecord->retirement = $ret;
            $salaryRecord->social_security = $soc;
            $salaryRecord->union_fee = $uni;
            $salaryRecord->net_salary = $net;
            $salaryRecord->create();
        }
        $users = $user->readAll();
        $employees = [];
        foreach ($users as $u) {
            if ($u['role'] !== 'admin') {
                $hours = $taskModel->sumHoursByUser($u['id']);
                $u['total_hours'] = $hours;
                $gross = $hours * (float)$u['hourly_rate'];
                $ret = $gross * 0.11;
                $soc = $gross * 0.03;
                $uni = $gross * 0.00;
                $net = $gross - $ret - $soc - $uni;
                $userTags = $tagModel->getTagsByUser($u['id']);
                foreach ($userTags as $t) {
                    $tagAmount = $t['mode'] === 'percent' ? ($gross * ((float)$t['amount'] / 100)) : (float)$t['amount'];
                    if ($t['operation'] === 'deduction') {
                        $net -= $tagAmount;
                    } else {
                        $net += $tagAmount;
                    }
                }
                $u['salary'] = $net;
                $u['retirement'] = 11;
                $u['social_security'] = 3;
                $u['union_fee'] = 0;
                $u['tags'] = $userTags;
                $employees[] = $u;
            }
        }
        include __DIR__ . '/../views/admin/users/salary.php';
        break;

    default:
        $users = $user->readAll();
        include __DIR__ . '/../views/admin/users/list.php';
        break;
}
?>
