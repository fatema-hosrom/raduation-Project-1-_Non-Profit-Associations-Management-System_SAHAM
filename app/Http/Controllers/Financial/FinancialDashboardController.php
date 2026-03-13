<?php

namespace App\Http\Controllers\Financial;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Manager;

class FinancialDashboardController extends Controller
{
    public function index(Request $request)
    {
        $managerId = $request->session()->get('financial_manager_id');
        $manager = Manager::find($managerId);
        return view('html.financial.dashboard', compact('manager'));
    }
}
