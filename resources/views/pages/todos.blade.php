<?php

use function Livewire\Volt\state;
use App\Models\Todo;

state(description: '', todos: fn() => Todo::all());

$addTodo = function () {
    Todo::create(['description' => $this->description]);

    $this->description = '';
    $this->todos = Todo::all();
};

$remove = function ($id) {
    Todo::find($id)->delete();
    $this->todos = Todo::all();
};

?>
<x-layout>

    @volt('todo')
        <div class="mt-2">
            <h1>Add Todo </h1>
            <form wire:submit="addTodo">
                <input class="form-control" type="text" wire:model="description">
                <button class="mt-2 btn btn-primary" type="submit">Add</button>
            </form>

            <h1>Todos</h1>
            <ul>
                @foreach ($todos as $todo)
                    <li>{{ $todo->description }} <button class="mt-2 btn btn-primary" wire:click="remove({{$todo->id}})">Remove</button>
                    </li>
                @endforeach
            </ul>
        </div>
    @endvolt
</x-layout>
