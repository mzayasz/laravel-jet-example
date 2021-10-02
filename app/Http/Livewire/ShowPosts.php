<?php

namespace App\Http\Livewire;

use App\Models\Post;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class ShowPosts extends Component
{
    use WithFileUploads;

    public $search, $post, $image, $identificador;

    public $sort = 'id';
    public $direction = 'desc';

    public $open_edit = false;

    protected $rules = [
        'post.title' => 'required',
        'post.content' => 'required'
    ];

    protected $listeners = ['render-show-posts' => 'render'];

    public function mount(){
        $this->identificador = rand();
        $this->post = new Post();
    }

    public function render()
    {
        $posts = Post::where('title', 'like', "%$this->search%")
                    ->orWhere('content', 'like', "%$this->search%")
                    ->orderBy($this->sort, $this->direction)
                    ->get();

        return view('livewire.show-posts', compact('posts'));
    }

    public function order($sort)
    {
        if($this->sort == $sort){
            $this->direction = $this->direction == 'desc' ? 'asc' : 'desc';
        }else{
            $this->sort = $sort;
            $this->direction = 'asc';
        }
    }

    public function edit(Post $post)
    {
        $this->post = $post;
        $this->open_edit = true;
    }

    public function update()
    {
        $this->validate();

        if($this->image){
            Storage::delete([$this->post->image]);
            $this->post->image = $this->image->store('posts');
        }

        $this->post->save();

        $this->reset(['open_edit', 'image']);
        $this->identificador = rand();

        //$this->emitTo('show-posts', 'render-show-posts');
        $this->emit('alert', 'El post se actualizo satisfactoriamente');
    }
}
