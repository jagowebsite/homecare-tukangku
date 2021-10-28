<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Order;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Access\Gate;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $employees = Employee::get();
        $orders = Order::get();
        $users = User::with(['roles'])
            ->whereHas('roles', function ($query) {
                $query->where('name', 'user');
            })
            ->get();
        $services = Service::get();
        return view(
            'pages.index',
            compact('employees', 'orders', 'users', 'services')
        );
    }
}
