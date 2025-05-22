<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;
use NotificationChannels\Telegram\TelegramMessage;

class LeadStatusChanged extends Notification
{
    use Queueable;
    protected $lead;

    /**
     * Create a new notification instance.
     */
    public function __construct($lead)
    {
        $this->lead = $lead;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['telegram'];
    }

    /**
     * @throws \Exception
     */
    public function toTelegram($notifiable)
    {
        $message = "Lid: {$this->lead->name}, Status: {$this->lead->status}";
        if ($this->lead->manager) {
            $message .= ", Menejer: {$this->lead->manager->name}";
        }
        try {
            return TelegramMessage::create()
                ->to(config('services.telegram.chat_id'))
                ->content($message);
        } catch (\Exception $e) {
            Log::error('Message not sent: ' . $e->getMessage());
            throw $e;
        }
    }
}
