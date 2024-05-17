<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Validator;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($request->user()->cannot('create', Task::class)) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $validator = Validator::make($request->all(), [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:255'],
            'status' => ['required', 'integer', 'in:0,1,2'],
        ]);


        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        } else {
            $task = Task::create([
                'title' => $request->title,
                'description' => $request->description,
                'status' => $request->status,
                'user_id' => $request->user()->id
            ]);

            return response()->json($task, 200);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $id)
    {
        if ($request->user()->cannot('view', Task::find($id))) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        return Task::find($id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if ($request->user()->cannot('update', Task::find($id))) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $validator = Validator::make($request->all(), [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:255'],
            'status' => ['required', 'integer', 'in:0,1,2'],
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        } else {
            $task = Task::find($id);
            $task->title = $request->title;
            $task->description = $request->description;
            $task->status = $request->status;
            $task->save();
            $task->unsetRelation('user');

            return response()->json($task, 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        if ($request->user()->cannot('delete', Task::find($id))) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        Task::destroy($id);

        return response()->json(['message' => 'Task deleted'], 200);
    }
}
