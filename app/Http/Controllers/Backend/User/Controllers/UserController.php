<?php

namespace App\Http\Controllers\Backend\User\Controllers;

use App\Http\Controllers\Backend\User\Requests\UserLoginRequest;
use App\Http\Controllers\Backend\User\Requests\UserRegisterRequest;
use App\Http\Controllers\Backend\User\Services\UserService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private $service;

    public function __construct(UserService $service)
    {
        $this->service = $service;
    }

    public function register(UserRegisterRequest $request){
        return $this->service->register($request->all());
    }

    public function login(UserLoginRequest $request){
        return $this->service->login($request);
    }
}
