<?php

namespace App\Models;

use CodeIgniter\Model;

class NotificationModel extends Model
{
    protected $table = 'notifications';
    protected $returnType = 'array';
    protected $allowedFields = [
        'user_id', 'type', 'title', 'message', 'link', 'is_read', 'read_at', 'created_at'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = false;

    public function unreadCount(int $userId): int
    {
        return $this->where('user_id', $userId)->where('is_read', 0)->countAllResults();
    }

    public function recentForUser(int $userId, int $limit = 5): array
    {
        return $this->where('user_id', $userId)
            ->orderBy('created_at', 'DESC')
            ->limit($limit)
            ->findAll();
    }

    public function markRead(int $id, int $userId): bool
    {
        return $this->where('id', $id)->where('user_id', $userId)
            ->update(null, ['is_read' => 1, 'read_at' => date('Y-m-d H:i:s')]);
    }

    public function markAllRead(int $userId): bool
    {
        return $this->where('user_id', $userId)->where('is_read', 0)
            ->update(null, ['is_read' => 1, 'read_at' => date('Y-m-d H:i:s')]) !== false;
    }

    public function createNotification(int $userId, string $type, string $title, ?string $message = null, ?string $link = null): int
    {
        return $this->insert([
            'user_id'  => $userId,
            'type'     => $type,
            'title'    => $title,
            'message'  => $message,
            'link'     => $link,
            'is_read'  => 0,
        ]);
    }
}
