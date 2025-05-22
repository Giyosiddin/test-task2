<?php

namespace App\Enums;

enum LeadStatusEnum:string
{
    case NEW = 'new';
    case IN_PROGRESS = 'in_progress';
    case COMPLETED = 'completed';
    case CANCELLED = 'cancelled';

}
