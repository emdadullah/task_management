<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\User;
use App\Helpers\TaskHierarchy;
use App\Repositories\Repository;
use App\Rules\ValidUser;
use App\Rules\ValidTask;

class TaskController extends Controller
{

    protected $model;

    protected $validation_rules = [];

    public function __construct(Task $task)
    {
        $this->model = new Repository($task);
        $this->validation_rules = [
            'title'=>'required',
            'points' => 'required|numeric|min:1|max:10',
            'is_done' => 'required|numeric|min:0|max:1',
            'user_id' => ['required', new ValidUser()],
            'parent_id' => new ValidTask
        ]; 
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function tree(TaskHierarchy $hierarchy,$userId = null)
    {
        $users =  User::get() ; 
        $tasks  = $userId == null ? $this->model->all() : Task::where('user_id',$userId)->get();  // Paginate Tasks 
       
        $hierarchy->setupItems($tasks);
        return $hierarchy->render();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tasks = $this->model->all();
        return view('tasks.index', compact('tasks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tasks.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate($this->validation_rules);

        // create record and pass in only fields that are fillable
        $this->model->create($request->only($this->model->getModel()->fillable));
        return redirect('/tasks')->with('success', 'task created!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $task = $this->model->show($id);
        return view('tasks.edit', compact('task'));        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate($this->validation_rules);

        $this->model->update($request->only($this->model->getModel()->fillable), $id);       
        return redirect('/tasks')->with('success', 'task updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->model->delete($id);
        return redirect('/tasks')->with('success', 'task deleted!');
    }
}
