<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;

class UserInfoController extends Controller
{
    public function me()
    {
        return new UserResource(auth()->user());
    }
}
