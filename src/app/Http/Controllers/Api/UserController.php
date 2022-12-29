<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Auth;

class UserController extends Controller
{
  public function index()
  {
    return new UserResource(Auth::user());
  }
}
