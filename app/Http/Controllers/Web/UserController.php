<?php


namespace App\Http\Controllers\Web;


use App\Http\Controllers\Controller;
use App\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::paginate(15);
        return response()->view('web.user.index', compact('users'));
    }
}
