<?php

namespace App\Services;

use App\Models\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;

class LoggerService
{
    public function logMessage($message)
    {  
        if (Auth::check()) {
        $user = Auth::user()->name;
        }else{
            $user = '';
        }
        $fullUrl = URL::full();
        $data = [
            'message' => $message,
            'route' => $fullUrl,
            'created_by' => $user,
        ];
        Log::create($data);
    }
}
