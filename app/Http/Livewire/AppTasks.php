<?php

namespace App\Http\Livewire;

use App\Models\Task;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\File;


class AppTasks extends Component
{
    use WithPagination,LivewireAlert;
    protected $listeners = ['taskAdded' => '$refresh'];
    protected $paginationTheme = 'bootstrap';

    public $title;
    public $description;
    public $image;
    public $taskId;
    public $deleteModal = false;
    public $showTaskModal = false;



    public function openDeleteModal($id)
    {
        $this->taskId =$id;
        $this->deleteModal = true;
        $task=auth()->user()->tasks()->find($this->taskId);
        $this->title = $task->title;

    }

    public function cancel()
    {
        $this->taskId = null;
        $this->title = null;
        $this->deleteModal = false;
    }

    public function destroy()
    {
        $task = Task::find($this->taskId);


        if(!empty($task->descriptive_image) && File::exists('images/'.$task->descriptive_image)) {
            unlink('images/'.$task->descriptive_image);
        }


        $task->delete();

        $this->deleteModal = false;
        $this->resetPage();
        $this->alert('success', 'Task deleted successfully!', [
            'position'  =>  'center',
            'timer'  =>  3000,
            'toast'  =>  true,
            'text'  =>  null,
            'showCancelButton'  =>  false,
            'showConfirmButton'  =>  false
        ]);

    }

    public function statusPending($id)
    {
        $task=auth()->user()->tasks()->find($id);
        $task->update(['status'=>false]);
        $this->alert('info', 'Task status Not completed!', [
            'position'  =>  'center',
            'timer'  =>  3000,
            'toast'  =>  true,
            'text'  =>  null,
            'showCancelButton'  =>  false,
            'showConfirmButton'  =>  false
        ]);
    }

    public function statusComplete($id)
    {
        $task=auth()->user()->tasks()->find($id);
        $task->update(['status'=>true]);
        $this->alert('success', 'Task status completed!', [
            'position'  =>  'center',
            'timer'  =>  3000,
            'toast'  =>  true,
            'text'  =>  null,
            'showCancelButton'  =>  false,
            'showConfirmButton'  =>  false
        ]);
    }

    public function editTask($id)
    {
        $this->emit('editTaskEmit',$id);
    }

    public function openShowTaskModal($id)
    {
        $this->taskId =$id;
        $this->showTaskModal = true;
        $task=auth()->user()->tasks()->find($this->taskId);
        $this->title = $task->title;
        $this->description = $task->description;
        $this->image = $task->descriptive_image;
    }

    public function close()
    {
        $this->showTaskModal = false;
        $this->taskId = null;
        $this->title = null;
        $this->description = null;
        $this->image = null;
    }
    public function render()
    {
        $totalTasks = auth()->user()->tasks()->count();
        $tasks = auth()->user()->tasks()->paginate(5);
        return view('livewire.app-tasks', [
            'totalTasks' => $totalTasks,
            'tasks' => $tasks
        ]);
    }


}
