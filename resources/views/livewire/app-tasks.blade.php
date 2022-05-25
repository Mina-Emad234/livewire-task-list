<div>
    <h3 class="text-center">My Task ({{$totalTasks}})</h3>
    <table class="table bg-white ">
        <thead>
            <tr>
                <th>#</th>
                <th>Image</th>
                <th>Title</th>
                <th>Status</th>
                <th>operations</th>
            </tr>
        </thead>
        <tbody>
        @php  $taskNumber=($tasks->currentPage()-1)*5; @endphp
            @foreach ($tasks as $task)
            <tr>
                <td scope="row">{{++$taskNumber}}</td>
                <td><img src="{{asset('/images/' . $task->descriptive_image)}}" alt="{{ $task->title }}" width="100"></td>
                <td><a class="badge badge-light btn" style="font-size: 0.9rem" data-toggle="modal" data-target="#showModal" wire:click="openShowTaskModal({{ $task->id }})">{{ $task->title }}</a></td>
                <td>{{ $task->status == true ? 'Completed' : 'Pending' }}</td>
                <td>
                    <i class="fa-solid fa-pen-to-square fa-lg" wire:click="editTask({{ $task->id }})"></i>
                    <i class="fa-solid fa-trash-can fa-lg" data-toggle="modal" data-target="#deleteModal" wire:click="openDeleteModal({{ $task->id }})"></i>
                    @if($task->status)
                    <i class="fa-solid fa-circle-check fa-lg" wire:click="statusPending({{$task->id}})"></i>
                    @else
                    <i class="fa-solid fa-circle-minus fa-lg" wire:click="statusComplete({{$task->id}})"></i>
                    @endif
                </td>
            </tr>
            @endforeach

        </tbody>
    </table>
    {{ $tasks->links() }}
<!-- Delete Modal -->
    <div wire:ignore.self class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Delete task</h5>
                    <button type="button" wire:click.prevent="cancel()" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure that you wand {{$title}}?
                </div>
                <div class="modal-footer">
                    <button type="button" wire:click.prevent="cancel()" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" wire:click.prevent="destroy()" class="btn btn-primary" data-dismiss="modal">Delete task</button>
                </div>
            </div>
        </div>
    </div>
<!-- Show Modal -->
    <div wire:ignore.self class="modal fade" id="showModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Show Task Details</h5>
                    <button type="button" wire:click.prevent="close()" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-3">
                            <img src="{{asset('/images/' . $image)}}" alt="{{ $title }}" width="100">
                        </div>
                        <div class="col-lg-9">
                            <h3>{{ $title }}</h3>
                            <p>{!! $description !!}</p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" wire:click.prevent="close()" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
