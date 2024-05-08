<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Helpers\RoleHelper;
use Illuminate\Support\Facades\Log;



class ProductController extends Controller

  
{
    public function index()
    
    {
        if (RoleHelper::SuperAdmin()) {
            $query = Task::query();

            if ($request->has('sort_by') && $request->sort_by == 'due_date') {
                $query->orderBy('due_date');
            }
    
            if ($request->has('status')) {
                $query->where('status', $request->status);
            }
    
            $Task = $query->get();
            log::info($Task);
    
        return response()->json(['tasks'=>$Task]);
        }
        return response()->json(['error' => 'Unauthorized'], 403);

    }

    public function store(Request $request)
    {
        if (RoleHelper::SuperAdmin()) {
        $request->validate([
            'title' => 'required',
            'due_date' => 'required|date|after:today',
            'description' => 'nullable',
            'status' => 'required|in:pending,in_progress,completed',
            
        ]);

        $user = Auth::guard('api')->user();
        $Task = Task::create($request->all());
        return response()->json($Task, 201);

    }
    return response()->json(['error' => 'Unauthorized'], 403);    
    }

    public function show($task_id)
    
    {
        if (RoleHelper::SuperAdmin()) {
       
        $Task=Product::findOrfail($task_id);
        return response()->json(['tasks'=>$Task]);
    }
      
    return response()->json(['error' => 'Unauthorized'], 403);
             
      
    }

    public function update(Request $request, $Task_id)
    
    {
        if (RoleHelper::SuperAdmin()) {
        $request->validate([
            'title' => 'required',
            'due_date' => 'required|date|after:today',
            'description' => 'nullable',
            'status' => 'required|in:pending,in_progress,completed',
       
        ]);
        $Task=Task::findOrfail($Task_id);

      
        $Task->update($Task->all());

        return response()->json(['tasks'=>$Task]);
    }
      
    return response()->json(['error' => 'Unauthorized'], 403);
             
      
    }

    public function destroy($Task_id)
{
    if (RoleHelper::SuperAdmin()) {
        $Task = Task::findOrFail($Task_id);
        
        
        $Task->delete();
        
        return response()->json(null, 204);
    }
    
    return response()->json(['error' => 'Unauthorized'], 403);
}


}
