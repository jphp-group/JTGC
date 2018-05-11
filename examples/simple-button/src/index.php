<?php 

use gui;

UXApplication::runLater(fn() => {
    new \forms\MainForm()->show();
});