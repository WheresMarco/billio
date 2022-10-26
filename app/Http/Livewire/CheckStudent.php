<?php

namespace App\Http\Livewire;

use App\Http\Controllers\CheckStudentController;
use Livewire\Component;

class CheckStudent extends Component
{
    public $nin = '';

    public $valid = false;

    public function checkStudent()
    {
        // Check if student is member.
        $valid = (new CheckStudentController())->isStudentMember($this->nin);

        $this->valid = $valid;
    }

    public function render()
    {
        return view('livewire.check-student');
    }
}
