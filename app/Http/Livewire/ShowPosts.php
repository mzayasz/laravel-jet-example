<?php

namespace App\Http\Livewire;

use App\Models\Post;
use Livewire\Component;

class ShowPosts extends Component
{

    /*public $titulo;

    public function mount($title){
        $this->titulo = $title;
    }*/

    public $search;

    public $sort = 'id';
    public $direction = 'desc';

    protected $listeners = ['render-show-posts' => 'render'];

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
}
