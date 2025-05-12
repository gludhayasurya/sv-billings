<?php

namespace App\Http\Controllers;

use App\Models\Worker;
use Illuminate\Http\Request;

class WorkerController extends Controller
{
    public function index()
    {
        $workers = Worker::all();
        return view('workers.index', compact('workers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'wages' => 'required|numeric|min:0',
        ]);

        Worker::create($request->only(['name', 'wages']));

        return redirect()->route('workers.index')->with('success', 'Worker added successfully');
    }

    public function update(Request $request, Worker $worker)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'wages' => 'required|numeric|min:0',
        ]);

        $worker->update($request->only(['name', 'wages']));

        return redirect()->route('workers.index')->with('success', 'Worker updated successfully');
    }

    public function destroy(Worker $worker)
    {
        $worker->delete();

        return redirect()->route('workers.index')->with('success', 'Worker deleted successfully');
    }

    // WorkerController.php
    public function getWorkerDetails($id)
    {
        $worker = Worker::findOrFail($id);
        return response()->json([
            'wage' => $worker->wages,
        ]);
    }

}
