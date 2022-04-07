<?php


namespace App\Services\Sms;

use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SendService
{
    private string $baseUrl;

    public function __construct()
    {
        $this->baseUrl = config('sms.sms-api-url');
    }

    public function __invoke(string $phone, string $message)
    {
        $data = ['login' => config('sms.sms-login'),
            'pwd' => config('sms.sms-password'),
            'CgPN' => config('sms.sms-sender'),
            'CdPN' => $phone,
            'text' => $message,];

        $resp = $this->sendRequest($data);
        $resp->successful() ?: Log::error($resp);
    }

    protected function sendRequest($data): PromiseInterface|Response
    {
        return Http::accept('application/json')->post($this->baseUrl, $data);
    }
}
