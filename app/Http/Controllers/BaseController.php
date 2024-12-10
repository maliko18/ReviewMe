<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    public User $user;
    public function __construct()
    {
        $this->user=User::query()->first();

    }
}
