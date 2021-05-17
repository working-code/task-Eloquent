<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $table = 'blog';

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function getMessages(int $countMessage = 20): array
    {
        $messages = Message::with('user')->limit($countMessage)->get();
        if ($messages->count()) {
            return $messages->toArray();
        }
        return [];
    }

    public function getMessagesForUserId(int $userId, int $countMessage = 20): array
    {
        $messages = Message::with('user')
            ->where('user_id', '=', $userId)
            ->limit($countMessage)
            ->get();
        if ($messages->count()) {
            return $messages->map(function ($event) {
                return [
                    'id' => $event->id,
                    'message' => $event->message,
                    'date' => $event->date,
                    'user' => $event->user->name
                ];
            })->toArray();
        }
        return [];
    }

    public function deleteMessageForId(int $id): bool
    {
        return Message::query()->where('id', '=', $id)->delete();
    }
}
