<?php

namespace App\Jobs;

use App\Models\Link;
use App\Models\User;
use App\Notifications\LinkReport;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class DailyLinkReport implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $admins = User::admins()->get();

        $report = new LinkReport(
            Link::where('created_at', '>', now()->subDay())->count()
        );

        foreach($admins as $admin) {
            $admin->notify($report);
        }
    }
}
