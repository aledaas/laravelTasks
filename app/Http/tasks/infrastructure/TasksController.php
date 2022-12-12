<?php

namespace App\Http\tasks\infrastructure;


use App\Http\Controllers\Controller;
use App\Http\Exceptions\HttpBussinesRuleException;
use App\Http\tasks\aplication\TaskCollection;
use App\Http\tasks\aplication\TaskResource;
use App\Http\tasks\aplication\TaskUpdateRequest;
use App\Http\tasks\domain\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TasksController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \App\Http\tasks\aplication\TaskCollection
     */
    public function index(Request $request)
    {
        $tasks = Task::all();
        return new TaskCollection($tasks);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \App\Http\tasks\aplication\TaskResource
     */
    public function store(Request $request)
    {
        $payload = $request->all();

        $TaskValidator = Validator::make($request->all(), [
            'priority' => ['required'],
            'assigner' => ['required'],
            'tags' => ['required'],
            'description' => ['required'],
            'due_date' => ['required'],
            'status' => ['required','IN:Todo,Doing,Blocked,Done'],
        ],[
            'priority.required' => 'Priority is required',
            'assigner.required' => 'Assigner is required',
            'tags.required' => 'Tags is required',
            'description.required' => 'Description is required',
            'due_date.required' => ['Due Date is required'],
            'status.required' => 'Status is required',
            'status.i_n' => 'Status Values in (Todo,Doing,Blocked,Done)',
        ]);

        if ($TaskValidator->fails()) {
            throw new HttpBussinesRuleException($TaskValidator->errors());
        }

        $task= Task::create([
            'priority' => $payload['priority'],
            'assigner' => $payload['assigner'],
            'tags' => $payload['tags'],
            'description' => $payload['description'],
            'due_date' => $payload['due_date'],
            'status' => $payload['status'],
        ]);

        return new TaskResource($task);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Http\tasks\domain\ $task
     * @return \App\Http\tasks\aplication\TaskResource
     */
    public function show(Request $request, Task $task)
    {
        return new TaskResource($task);
    }

    /**
     * @param \App\Http\tasks\aplication\TaskUpdateRequest $request
     * @param \App\Http\tasks\domain\ $task
     * @return \App\Http\tasks\aplication\TaskResource
     */
    public function update(TaskUpdateRequest $request, Task $task)
    {
        $task->update($request->validated());

        return new TaskResource($task);
    }

    /**
     * @param \Illuminate\Http\Request $request
      $payload = $request->all();
     * @param \App\Http\tasks\domain\ $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Task $task)
    {
        $task->delete();

        return response()->noContent();
    }
}
