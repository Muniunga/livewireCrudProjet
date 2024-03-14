<?php

namespace App\Livewire;

use App\Models\Todo;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class TodoList extends Component
{
    use WithPagination;
    #[Rule('required|min:2|max:70')]
    public $name;
    public $search;

    public function create(){


    $validated= $this->validateOnly('name');
    $todo = new Todo;
    $todo->name = $this->name;
    $todo->save($validated);

    $this->reset(['name']);
    request()->session()->flash('success', 'Todo created Successfully!');

    }
    public function render()
    {
        $data['getTodo']= Todo::latest()->where('name','like',"%{$this->search}%")->paginate(2);
        return view('livewire.todo-list', $data);
    }
}
