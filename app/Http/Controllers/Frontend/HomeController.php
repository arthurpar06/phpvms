<?php

namespace App\Http\Controllers\Frontend;

use App\Contracts\Controller;
use App\Models\Enums\UserState;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return View
     */
    public function index(): View
    {
        try {
            /** @var Collection<int, User> $users */
            $users = User::with('home_airport')->where('state', '!=', UserState::DELETED)->orderBy('created_at', 'desc')->take(4)->get();
        } catch (\PDOException $e) {
            Log::emergency($e);
            return view('system/errors/database_error', [
                'error' => $e->getMessage(),
            ]);
        }

        // No users
        if ($users->isEmpty()) {
            return view('system/errors/not_installed');
        }

        return view('home', [
            'users' => $users,
        ]);
    }
}
