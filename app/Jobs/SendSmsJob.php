<?php

namespace App\Jobs;

use App\Models\SmsConfirm;
use App\Services\Sms\SendService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendSmsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public SmsConfirm $smsConfirm;
    public int        $tries = 3;

    /**
     * Create a new job instance.
     *
     * @param SmsConfirm $smsConfirm
     */
    public function __construct(SmsConfirm $smsConfirm)
    {
        $this->smsConfirm = $smsConfirm;
    }

    /**
     * Execute the job.
     *
     * @param SendService $smsService
     *
     * @return void
     */
    public function handle(SendService $smsService): void
    {
        $smsService($this->smsConfirm->phone, $this->smsConfirm->code . '-vash kod podtverjdeniya nomera v Mobile Pos, dlya spravki zvonite 94 2157788');
    }
}
