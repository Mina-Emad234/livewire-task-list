<div>
    <h3 class="text-center">@if($taskId) Update Task @else Add New Task @endif</h3>
    @if(session()->has('message'))
        <div class="alert alert-success">
                {{session()->get('message')}}
        </div>
    @endif
    <div class="form-group">
        <label for="title">Title</label>
        <input type="text" wire:model="title" class="form-control @error('title') is-invalid @enderror @if(!empty($title)) is-valid @endif">
        @error('title')
        <b class="text text-danger">
            {{$message}}
        </b>
        @enderror
    </div>

    <div class="form-group">
        <label for="title">Description</label>
        <textarea wire:model="description" class="form-control @error('description') is-invalid @enderror @if(!empty($description)) is-valid @endif">{{$description}}</textarea>
        @error('description')
        <b class="text text-danger">
            {{$message}}
        </b>
        @enderror
    </div>

    <div class="form-group">
        <label for="title">Descriptive Image</label>
        <div>
        @if($image)
            <span>
                    <img class="m-2 p-2" src="{{asset('images/'. $image)}}" width="120">
            </span>
        @endif

        @if($task_image && in_array($task_image->extension(),['png','jpg','jpeg','gif']))
            <span>
                    <img class="m-2 p-2" src="{{$task_image->temporaryUrl()}}" width="120">
            </span>
        @endif
        </div>
        <input type="file" id="{{$fileInputId}}" wire:model="task_image" namegit initgit init="task_image" class="form-control-file" accept="image/*">
        @error('task_image')
        <b class="text text-danger">
            {{$message}}
        </b>
        @enderror
    </div>

    <div class="form-group">
        @if($taskId)
            <button wire:click.prevent="updateTask()" class="btn btn-primary btn-block">Update</button>
            <button wire:click.prevent="resetData()" class="btn btn-secondary btn-block">Add New Task</button>
        @else
        <button wire:click.prevent="addTask()" class="btn btn-primary btn-block">Add</button>
        @endif
    </div>
</div>
