<?php

namespace App\Jobs;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;


class DeactivatePromotionJob implements ShouldQueue
{
    use Dispatchable, Queueable;

    protected $promotion;

    public function __construct($promotion)
    {
        $this->promotion = $promotion;
    }

    public function handle()
    {
        if (Carbon::now()->gte($this->promotion->end_date) && $this->promotion->status !== 'closed') {
            $this->promotion->update(['status' => 'closed']);
        }
    }
}
