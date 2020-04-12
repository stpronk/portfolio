<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Wysiwyg extends Component
{
    public $fields = [];

    public function mount ()
    {
        $this->fields = [
            'content' => '',
        ];
    }

    public function persist ()
    {
        try {
            $this->save();
        } catch (\Exception $e) {
            $this->addError('save', 'The save function does not exist, create one or overwrite the persist function.');
        }
    }

    public function render ()
    {
        return view('livewire.wysiwyg', [
            'fields' => $this->fields
        ]);
    }
}
