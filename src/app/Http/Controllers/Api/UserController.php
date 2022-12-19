<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Auth;
use Request;

class UserController extends Controller
{
  public function index(Request $request)
  {
    return Auth::user();
  }
}
