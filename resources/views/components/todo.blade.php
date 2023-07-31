<?php

use App\Models\Todo;
use function Livewire\Volt\{state};

$todo = function () {
    if (request()->get('search')) {
        return Todo::where('description', 'like', '%' . request()->get('search') . '%')->get();
    }

    return Todo::all();
};

state(description: null, todos: $todo);

$addTodo = function () {
    Todo::create(['description' => $this->description]);

    $this->description = '';
    $this->todos = Todo::all();
};

$remove = function ($id) {
    Todo::find($id)->delete();
    $this->todos = Todo::all();
};

$markCompleted = function ($id) {
    $todo = Todo::find($id);
    $todo->completed = !$todo->completed;
    $todo->save();
    $this->todos = Todo::all();
};

?>
@volt
<div class="mt-5">
    <h3>Add Todo </h3>
    <div class="card card-body mb-5">
        <form wire:submit="addTodo">
            <div class="form-label">
                <label for="">Title</label>
                <input class="form-control" type="text" wire:model="description">
            </div>
            <button class="mt-2 btn btn-dark px-5" type="submit">Save</button>
        </form>
    </div>

    <h3>Todos</h3>
    @if($this->todos->count() === 0)
        <p>No todos yet.</p>
    @else
        <table class="table table-bordered">
            <tr>
                <th>Todo</th>
                <th>Created</th>
            </tr>

            @foreach ($todos as $todo)
                <tr>
                    <td>
                            <span class="badge text-bg-light">
                                {{$todo->completed?'✅':'🔴'}} {{ $todo->description }}
                            </span>
                        <span class="badge text-bg-light">{{ $todo->created_at->format('d-m-Y') }}
                            </span>
                    </td>
                    <td>
                        <button class="mt-2 btn btn-sm btn-primary"
                                wire:click="markCompleted({{ $todo->id }})">
                            <span>Mark</span>
                        </button>

                        <button class="mt-2 btn btn-sm btn-primary" wire:confirm="Are you sure"
                                wire:click="remove({{ $todo->id }})">
                            <span>Remove</span>
                        </button>
                    </td>
                </tr>
            @endforeach
        </table>
    @endif
</div>
@endvolt
