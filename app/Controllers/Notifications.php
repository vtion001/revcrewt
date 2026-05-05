<?php

namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;
use App\Models\NotificationModel;

class Notifications extends BaseController
{
    use ResponseTrait;
    protected $notifModel;

    public function __construct()
    {
        $this->notifModel = new NotificationModel();
    }

    private function checkLogin(): bool
    {
        return session()->get('logged_in') === true;
    }

    // GET /api/notifications — all for current user
    public function index()
    {
        if (!$this->checkLogin()) return $this->failUnauthorized('Login required.');
        $userId = (int) session()->get('user_id');
        $notifications = $this->notifModel->recentForUser($userId);
        $unreadCount = $this->notifModel->unreadCount($userId);
        return $this->respond(['notifications' => $notifications, 'unread_count' => $unreadCount]);
    }

    // GET /api/notifications/unread-count
    public function unreadCount()
    {
        if (!$this->checkLogin()) return $this->failUnauthorized('Login required.');
        $userId = (int) session()->get('user_id');
        return $this->respond(['count' => $this->notifModel->unreadCount($userId)]);
    }

    // POST /api/notifications/{id}/read
    public function markRead(int $id)
    {
        if (!$this->checkLogin()) return $this->failUnauthorized('Login required.');
        $userId = (int) session()->get('user_id');
        $this->notifModel->markRead($id, $userId);
        return $this->respondCreated(['message' => 'Marked as read.']);
    }

    // POST /api/notifications/read-all
    public function markAllRead()
    {
        if (!$this->checkLogin()) return $this->failUnauthorized('Login required.');
        $userId = (int) session()->get('user_id');
        $this->notifModel->markAllRead($userId);
        return $this->respondCreated(['message' => 'All marked as read.']);
    }
}
