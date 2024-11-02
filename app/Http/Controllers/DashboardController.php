<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use App\Models\Email;
use App\Models\Order;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;


class DashboardController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $last_payments = Order::where('status', '=', 'COMPLETED')
            ->where('type', '=', 'PAYPAL')
            ->orderBy('created_at', 'desc')
            ->limit(25)
            ->get();

        $todayutc = Carbon::createFromTimestampUTC(time());
        $next_events = Event::where('hide', '=', 0)
            ->where('date', '>=', $todayutc)
            ->orderBy('date', 'asc')
            ->limit(8)
            ->get();

        return view('admin.dashboard', [
            'last_payments' => $last_payments,
            'next_events' => $next_events
        ]);
    }
}
