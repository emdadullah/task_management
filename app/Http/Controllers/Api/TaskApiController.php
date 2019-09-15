<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\User;
use App\Rules\ValidTask;
use App\Rules\ValidUser;
use App\Repositories\Repository;
use App\Http\Controllers\Api\BaseController as BaseController;
use Validator;


class TaskApiController extends BaseController
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, $this->validation_rules);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        $task = $this->model->create($request->only($this->model->getModel()->fillable));
        return $this->sendResponse($task->toArray(), 'Task created successfully.');
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
        $input = $request->all();
        $validator = Validator::make($input, $this->validation_rules);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        $task = $this->model->update($request->only($this->model->getModel()->fillable), $id);
        return $this->sendResponse($task->toArray(), 'Task updated successfully.');
    }
}
