<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Livewiremain;

class Livewiremaincrud extends Component
{

    public $posts, $title, $body, $post_id;
    public $updateMode = false;

    public function render()
    {
        $this->posts = Livewiremain::all();
        return view('livewire.livewiremaincrud');
    }

    private function resetInputFields(){
        $this->title = '';
        $this->body = '';
    }

    public function store()
    {
        $validatedDate = $this->validate([
            'title' => 'required',
            'body' => 'required',
        ]);
  
        Livewiremain::create($validatedDate);
  
        session()->flash('message', 'Post Created Successfully.');
  
        $this->resetInputFields();
    }

    public function edit($id)
    {
        $post = Livewiremain::findOrFail($id);
        $this->post_id = $id;
        $this->title = $post->title;
        $this->body = $post->body;
  
        $this->updateMode = true;
    }

    public function cancel()
    {
        $this->updateMode = false;
        $this->resetInputFields();
    }
  
    public function update()
    {
        $validatedDate = $this->validate([
            'title' => 'required',
            'body' => 'required',
        ]);
  
        $post = Livewiremain::find($this->post_id);
        $post->update([
            'title' => $this->title,
            'body' => $this->body,
        ]);
  
        $this->updateMode = false;
  
        session()->flash('message', 'Post Updated Successfully.');
        $this->resetInputFields();
    }

    public function delete($id)
    {
        Livewiremain::find($id)->delete();
        session()->flash('message', 'Post Deleted Successfully.');
    }
}
