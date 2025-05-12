<?php

namespace App\Http\Controllers;

use App\Models\Billing;
use App\Models\Material;
use App\Models\Worker;
use Illuminate\Http\Request;
use NumberToWords\NumberToWords;

class BillingController extends Controller
{
    public function index()
    {
        $materials = Material::all();
        $workers = Worker::all();
        $billings = Billing::with(['material', 'worker'])->latest()->get();

        // Calculate overall total
        $overallTotal = $billings->sum('total');

        // Convert overall total to words
        $numberToWords = new NumberToWords();
        $numberTransformer = $numberToWords->getNumberTransformer('en');

        // You can customize formatting here
        $totalInWords = $overallTotal > 0
            ? ucfirst($numberTransformer->toWords($overallTotal)) . ' rupees only'
            : 'Zero rupees only';

            // dd($totalInWords, $overallTotal, $materials, $workers, $billings);

        return view('billings.index', compact('materials', 'workers', 'billings', 'overallTotal', 'totalInWords'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        // Calculate the total for materials or workers
        if ($request->material_id != null) {
            $total = $request->sqft * $request->rate * $request->qty;
        } else {
            $total = ($request->wage * $request->no_of_days) + ( $request->food * $request->no_of_days) + $request->transport;
        }

        // Convert work dates to a comma-separated string
        $workDates = is_array($request->work_dates) ? implode(',', $request->work_dates) : null;

        // Create the billing entry
        Billing::create([
            'type' => ($request->material_id != null) ? 'material' : 'worker',
            'reference_id' => $request->material_id ?? $request->worker_id,
            'sqft' => $request->sqft ?? null,
            'qty' => $request->qty ?? null,
            'rate' => $request->rate ?? null,
            'total' => $total,
            'wages' => $request->wage ?? null,
            'food' => $request->food ?? null,
            'transport' => $request->transport ?? null,
            'no_of_days' => $request->no_of_days ?? null,
            'work_dates' => $workDates,  // Store the comma-separated dates
        ]);

        return redirect()->route('billings.index')->with('success', 'Billing added successfully.');
    }

    public function destroy(Billing $billing)
    {
        $billing->delete();
        return redirect()->route('billings.index')->with('success', 'Billing entry deleted successfully.');
    }

    public function print(Billing $billing)
    {
        return view('billings.print', compact('billing'));
    }
}
