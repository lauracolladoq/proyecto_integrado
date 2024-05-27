<?php

namespace App\Livewire;

use App\Models\Post;
use Livewire\Component;

class MyProfile extends Component
{
    public function render()
    {
        $posts = Post::select('id', 'user_id', 'image', 'content', 'created_at')
            ->where('user_id', auth()->user()->id)
            ->orderBy('created_at', 'desc')
            ->with('user', 'tags', 'comments')
            ->get();

        $myLikes = Post::whereHas('usersLikes', function ($q) {
            $q->where('user_id', auth()->user()->id);
        })->get();

        return view('livewire.my-profile', compact('posts', 'myLikes'));
    }

    public function like(Post $post)
    {
        //toogle para agregar o quitar like
        $post->usersLikes()->toggle(auth()->user()->id);
    }
}