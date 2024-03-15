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

    public $editingTodoID;
    #[Rule('required|min:2|max:70')]
    public $editingTodoName;

    public function create()
    {


        $validated = $this->validateOnly('name');
        $todo = new Todo;
        $todo->name = $this->name;
        $todo->save($validated);

        $this->reset(['name']);
        request()->session()->flash('success', 'Todo created Successfully!');
    }

    public function delete(Todo $todo)
    {
        $todo->delete();
        request()->session()->flash('success', 'Todo deleted Successfully!');
    }

    public function toggle(Todo $todo)
    {
        $todo->completed = !$todo->completed;
        $todo->save();

        request()->session()->flash('success', 'Todo checked Successfully!');
    }

    public function edit($todoID)
    {

        $this->editingTodoID = $todoID;
        $this->editingTodoName = Todo::find($todoID)->name;
    }
    public function cancel()
    {
        $this->reset('editingTodoID', 'editingTodoName');
    }
    public function update()
    {
        $this->validateOnly('editingTodoName');
        Todo::find($this->editingTodoID)->update(
            [
                'name' => $this->editingTodoName
            ]
        );
        $this->cancel();
    }

    public function render()
    {
        $data['getTodo'] = Todo::latest()->where('name', 'like', "%{$this->search}%")->paginate(5);
        return view('livewire.todo-list', $data);
    }
}
