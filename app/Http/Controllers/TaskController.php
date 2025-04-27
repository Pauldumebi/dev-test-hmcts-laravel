<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string',
            'description' => 'nullable|string',
            'status' => 'required|string',
            'due_date' => 'required|date',
        ]);

        if ($validator->fails()) 
        {
            $errors = $validator->errors();
            $missingFields = $errors->keys();
            
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $errors,
                'missing_fields' => $missingFields
            ], 400);
        }

        $task = Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'status' => $request->status ?? 'pending',
            'due_date' => $request->due_date,
        ]);

        return response()->json($task, 201);
    }

    public function show($id)
    {
        try 
        {
            $task = Task::findOrFail($id);
            return response()->json($task);
        } 
        catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) 
        {
            return response()->json(['error' => 'Task not found'], 404);
        }
    }

    public function index()
    {
        $tasks = Task::all();
        return response()->json($tasks);
    }

    public function updateStatus(Request $request, $id)
    {
        $task = Task::findOrFail($id);
        $task->status = $request->status;
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
        catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) 
        {
            return response()->json(['error' => 'Task not found'], 404);
        }
       
    }
}
