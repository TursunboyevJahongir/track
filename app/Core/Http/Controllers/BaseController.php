<?php

namespace App\Core\Http\Controllers;

use App\Core\Services\CoreService;
use App\Core\Traits\Responsable;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller;

abstract class BaseController extends Controller
{
    use Responsable, AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected CoreService $service;

    public function __construct(CoreService $service)
    {
        $this->service = $service;
    }
}
