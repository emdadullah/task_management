@extends('base') 
@section('main')
<div class="row">
    <div class="col-sm-8 offset-sm-2">
        <h1 class="display-3">Update a task</h1>

        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        <br /> 
        @endif
        <form method="post" action="{{ route('tasks.update', $task->id) }}">
            @method('PATCH') 
            @csrf
            {{--  <div class="form-group">
                <label for="first_name">First Name:</label>
                <input type="text" class="form-control" name="first_name" value={{ $task->first_name }} />
            </div>

            <div class="form-group">
                <label for="last_name">Last Name:</label>
                <input type="text" class="form-control" name="last_name" value={{ $task->last_name }} />
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="text" class="form-control" name="email" value={{ $task->email }} />
            </div>
            <div class="form-group">
                <label for="city">City:</label>
                <input type="text" class="form-control" name="city" value={{ $task->city }} />
            </div>
            <div class="form-group">
                <label for="country">Country:</label>
                <input type="text" class="form-control" name="country" value={{ $task->country }} />
            </div>
            <div class="form-group">
                <label for="job_title">Job Title:</label>
                <input type="text" class="form-control" name="job_title" value={{ $task->job_title }} />
            </div>  --}}

            <div class="form-group">    
                <label for="title">Title :</label>
                <input type="text" class="form-control" name="title" value={{ $task->title }} />
            </div>
  
            <div class="form-group">
                <label for="user_id">User Id:</label>
                <input type="text" class="form-control" name="user_id" value="{{ $task->user_id }}" />
            </div>
  
            <div class="form-group">
              <label for="parent_id">Task Parent Id:</label>
              <input type="text" class="form-control" name="parent_id" value="{{ $task->parent_id }}"/>
            </div>
  
            <div class="form-group">
                <label for="points">Points :</label>
                <input type="number" class="form-control" name="points" value={{ $task->points }} />
            </div>
            
            <input type="checkbox" name="is_done" value="1" @if( $task->is_done ) checked="1" @endif> Done 
            <br/>
            <br/>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
</div>
@endsection