<?php

namespace App\Console\Commands;

use App\Enums\LeadStatusEnum;
use App\Models\Lead;
use Illuminate\Console\Command;

class CheckExpireLeads extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'leads:check-expire';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Lead::where('status', LeadStatusEnum::NEW->value)
            ->where('created_at', '<', now()->subHours(24))
            ->update(['status' => 'cancelled']);
        $this->info('Done');
    }
}
