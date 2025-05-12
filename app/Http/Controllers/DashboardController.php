<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Worker;
use App\Models\Material;
use App\Models\Billing;

class DashboardController extends Controller
{
    public function index()
    {
        $workerCount = Worker::count() ?? 0;
        $materialCount = Material::count() ?? 0;
        $totalWages = Billing::where('type', 'worker')->sum('total') ?? 0;
        $months = $this->getPast6Months() ?? [];
        $workerExpenses = $this->getExpenses('worker') ?? [];
        $materialExpenses = $this->getExpenses('material') ?? [];

        return view('dashboard', compact(
            'workerCount',
            'materialCount',
            'totalWages',
            'months',
            'workerExpenses',
            'materialExpenses'
        ));
    }

    private function getPast6Months()
    {
        return collect(range(0, 5))->map(fn($i) => now()->subMonths($i)->format('M'))->reverse()->values();
    }

    private function getExpenses($type)
    {
        return collect(range(0, 5))->map(function ($i) use ($type) {
            $month = now()->subMonths($i);
            return Billing::where('type', $type)
                ->whereMonth('created_at', $month->month)
                ->whereYear('created_at', $month->year)
                ->sum('total');
        })->reverse()->values();
    }
}
