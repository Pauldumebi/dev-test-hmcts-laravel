<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Task;
use App\NotFound;
use App\HTTP\Requests\StoreTaskRequest;
use App\HTTP\Requests\UpdateTaskRequest;
use App\Models\status;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class TaskController extends Controller
{
    public function store(StoreTaskRequest $request)
    {
        $validated = $request->validated();

        $task = Task::create([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'status_id' => (int)$validated['status_id'],
            'due_date' => Carbon::createFromFormat('j/n/Y', $validated['due_date'])
                        ->format('Y-m-d'),
        ]);

        return response()->json($task, 201);
    }

    public function show($id)
    {
        try 
        {
            $task = Task::findOrFail($id)->join('status', 'tasks.status_id', '=', 'status.id')
                ->select('tasks.*', 'status.status as status')
                ->first();
                
            return response()->json($task);
        } 
        catch (ModelNotFoundException $e) 
        {
            Log::error('Task not found', ['id' => $id, 'error' => $e->getMessage()]);
            return response()->json(['error' => NotFound::TASK_NOT_FOUND], 404);
        }
    }

    public function getStatuses()
    {
        $statuses = status::all();

        if ($statuses->isEmpty()) {
            return response()->json(['error' => NotFound::STATUS_NOT_FOUND], 404);
        }

        $mappedStatuses = $statuses->map(function ($status) {
            return [
                'value' => $status->id,
                'text' => $status->status
            ];
        });

        $mappedStatuses->prepend([
            'value'     => '',
            'text' => 'Please select a status',
        ]);
       
        return response()->json($mappedStatuses->values());
    }

    public function index()
    {
        $tasks = Task::orderBy('created_at', 'desc')->get()->toArray();
        return response()->json($tasks);
    }

    public function updateStatus(UpdateTaskRequest $request, $id)
    {
        $validated = $request->validated();

        $task = Task::findOrFail($id);
        $task->status_id = $validated['status_id'];
        $task->save();

        return response()->json($task);
    }

    public function destroy($id)
    {
        try 
        {
            $task = Task::findOrFail($id);
            $task->delete();
    
            return response()->json(null, 204);
        } 
        catch (ModelNotFoundException $e) 
        {
            Log::error('Task not found', ['id' => $id, 'error' => $e->getMessage()]);
            return response()->json(['error' => NotFound::TASK_NOT_FOUND], 404);
        }
    }
}
