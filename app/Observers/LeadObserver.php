<?php

namespace App\Observers;

use App\Models\Lead;
use App\Notifications\LeadStatusChanged;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

class LeadObserver
{
    public function saved(Lead $lead): void
    {
        if ($lead->isDirty('status')) {

            Notification::route('telegram', config('services.telegram.chat_id'))
                ->notify(new LeadStatusChanged($lead));
        }

    }
}
