<?php

namespace App\Http\Livewire;

use App\Models\Post;
use Livewire\Component;

class CreatePost extends Component
{

    public $open = false;

    public $title, $content;

    protected $rules = [
        'title' => 'required|max:10',
        'content' => 'required|max:10'
    ];

    public function render()
    {
        return view('livewire.create-post');
    }

    public function save()
    {

        $this->validate();

        Post::create([
            'title' => $this->title,
            'content' => $this->content
        ]);

        $this->reset(['open', 'title', 'content']);

        //$this->emit('render-show-posts');
        $this->emitTo('show-posts', 'render-show-posts');
        $this->emit('alert', 'El post se creó satisfactoriamente');
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }
}
