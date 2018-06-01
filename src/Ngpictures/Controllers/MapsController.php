<?php
namespace Ngpictures\Controllers;


class MapsController extends Controller
{

    public function show()
    {
        $this->setLayout('blank-default');
        $this->viewRender('front_end/others/maps');
    }
}