<?php

namespace App\Helpers;

use App\Models\Notification;

class NotificationHelper {
    public static function send($userId, $title, $message, $type = 'info', $link = null) {
        \App\Models\Notification::create([
            'user_id' => $userId,
            'title'   => $title,
            'message' => $message,
            'type'    => $type,
            'link'    => $link,
        ]);
    }
}