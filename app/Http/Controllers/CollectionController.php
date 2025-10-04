<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Collection as CollectionModel;
use App\Repositories\CollectionRepositoryInterface;
use App\Repositories\CollectionRepository;
use App\Services\CollectionScheduler;

class CollectionController extends Controller
{
    protected $repo;
    protected CollectionScheduler $scheduler;

    /**
     * Use nullable type hints to avoid DI failures if the interface isn't bound.
     */
    public function __construct(?CollectionRepositoryInterface $repo = null, ?CollectionScheduler $scheduler = null)
    {
        $this->middleware('auth');

        // If the app container hasn't been bound for the interface, instantiate a default repo.
        $this->repo = $repo ?? new CollectionRepository(new CollectionModel());

        // Scheduler: try container resolution or fallback to a new instance.
        $this->scheduler = $scheduler ?? app(CollectionScheduler::class);
    }

    /**
     * Display a listing of the user's collections.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $collections = $this->repo->getUserCollections($user->id);

        // If your repo returns a Query/Collection you can paginate here.
        // For simplicity we pass the collection to the view.
        return view('collections.index', compact('collections'));
    }

    /**
     * Show form to create a collection.
     */
    public function create()
    {
        return view('collections.create');
    }

    /**
     * Store a newly created collection.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'collection_date' => 'required|date|after_or_equal:today',
            'collection_time' => 'required|date_format:H:i',
            'waste_type' => 'required|in:organic,recyclable,hazardous,electronic',
            'estimated_weight' => 'required|numeric|min:0',
            'address' => 'required|string|max:1000',
            'notes' => 'nullable|string',
        ]);

        $data['user_id'] = Auth::id();
        $data['status'] = 'pending';

        // Use scheduler which will create the collection and notify observers
        // (scheduler expects array with fields compatible with your repo/model).
        $collection = $this->scheduler->scheduleCollection($data);

        return redirect()->route('collections.index')->with('success', 'Recolección programada correctamente.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $collection = $this->repo->findById($id);
        if (!$collection || $collection->user_id !== Auth::id()) {
            abort(403);
        }

        return view('collections.edit', compact('collection'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $collection = $this->repo->findById($id);
        if (!$collection || $collection->user_id !== Auth::id()) {
            abort(403);
        }

        $data = $request->validate([
            'status' => 'required|in:pending,in_progress,completed,cancelled',
            'actual_weight' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
        ]);

        $this->repo->update($id, $data);

        return redirect()->route('collections.index')->with('success', 'Recolección actualizada.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $collection = $this->repo->findById($id);
        if (!$collection || $collection->user_id !== Auth::id()) {
            abort(403);
        }

        $this->repo->update($id, ['status' => 'cancelled']); // or delete: $this->repo->delete($id);

        return back()->with('success', 'Recolección eliminada.');
    }

    /**
     * Simple user report.
     */
    public function report()
    {
        $userId = Auth::id();
        $collections = $this->repo->getUserCollections($userId);

        $summary = [
            'total' => $collections->count(),
            'pending' => $collections->where('status', 'pending')->count(),
            'completed' => $collections->where('status', 'completed')->count(),
            'in_progress' => $collections->where('status', 'in_progress')->count(),
            'cancelled' => $collections->where('status', 'cancelled')->count(),
        ];

        return view('collections.report', compact('collections', 'summary'));
    }
}
