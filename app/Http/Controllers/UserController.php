<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Enums\UserRoleEnum;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get all the clients
        $user = Auth::user();
        $clients = User::whereNot('id', $user->id)->where('role', UserRoleEnum::CLIENT)->withCount('reservations');
        // dd($clients);

        // Show the list view
        return view('users.clients', ['clients' => $clients->paginate(20)]);
    }
}
