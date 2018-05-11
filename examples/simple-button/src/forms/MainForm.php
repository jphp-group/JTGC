<?php
namespace forms;

use gui;
use jtgc\parser\JTGC;
use std;

class MainForm extends UXForm
{
    public function show()
    {
        $this->layout = new JTGC([ // from array

            [
                "_" => "button",
                "text" => "test JTGC",
                "id" => "mySuperButton"
            ]

        ])->get([ 300, 300 ]); // [ 300, 300 ] is a size of panel
        parent::show(); // show form

        $this->mySuperButton->on("click", fn() => {
            UXDialog::show("mySuperButton is clicked!"); // show dialog
        });
    }
}