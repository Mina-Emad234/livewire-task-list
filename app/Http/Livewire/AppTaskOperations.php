<?php

namespace App\Http\Livewire;

use App\Models\Task;
use Illuminate\Support\Facades\File;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;

class AppTaskOperations extends Component
{
    use WithFileUploads,LivewireAlert;

    protected $listeners = ['editTaskEmit' => 'editTaskOperation'];
    public $title;
    public $description;
    public $image;
    public $task_image;
    public $task_image_name;
    public $taskId;
    public $fileInputId=0;

    protected $rules =[
      'title'=>'required|min:10',
      'description'=>'required|min:10|max:2000',
      'task_image'=>'nullable|mimes:jpg,png,jpeg,gif|between:0,4000',
    ];



    public function updatedTitle(){
        $this->validateOnly('title');
    }

    public function updatedDescription(){
        $this->validateOnly('description');
    }

    public function updatedTaskImage(){
        $this->validateOnly('task_image');
    }

    public function taskData()
    {
        $data = [
            'title' => $this->title,
            'description' => $this->description,
            'status' => false,
        ];

        if(!empty($this->task_image)){
            $data['descriptive_image']=$this->task_image_name;
        }
        return $data;
    }

    public function resetData()
    {
        $this->title = null;
        $this->description = null;
        $this->title = null;
        $this->image = null;
        $this->task_image = null;
        $this->task_image_name = null;
        $this->taskId = null;
        $this->fileInputId++;
    }

    public function addTask()
    {
        $this->validate();

        if ($this->task_image != '') {
            $this->task_image_name = md5($this->task_image . microtime()).'.'.$this->task_image->extension();
            $this->task_image->storeAs('/', $this->task_image_name, 'images');
        }
        auth()->user()->tasks()->create($this->taskData());

        $this->resetData();
        $this->emit('taskAdded');
        $this->alert('success', 'Task added successfully!', [
            'position'  =>  'center',
            'timer'  =>  3000,
            'toast'  =>  true,
            'text'  =>  null,
            'showCancelButton'  =>  false,
            'showConfirmButton'  =>  false
        ]);

    }

    public function editTaskOperation(Task $task)
    {
        $this->resetData();
        $this->taskId = $task->id;
        $this->title = $task->title;
        $this->description = $task->description;
        $this->image = $task->descriptive_image;
    }

    public function updateTask()
    {
        $this->validate();
        $task = Task::find($this->taskId);

        if ($this->task_image != '') {
            if(!empty($task->image) && File::exists('images/'.$task->image)) {
                unlink('images/'.$task->image);
            }
            $this->task_image_name = md5($this->task_image . microtime()) . '.' . $this->task_image->extension();
            $this->task_image->storeAs('/', $this->task_image_name, 'images');
        }

        $task->update($this->taskData());

        $this->resetData();
        $this->emit('taskAdded');

        $this->alert('success', 'Task updated successfully!', [
            'position'  =>  'center',
            'timer'  =>  3000,
            'toast'  =>  true,
            'text'  =>  null,
            'showCancelButton'  =>  false,
            'showConfirmButton'  =>  false
        ]);
    }

    public function render()
    {
        return view('livewire.app-task-operations');
    }
}
