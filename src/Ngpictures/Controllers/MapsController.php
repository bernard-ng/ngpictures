<?php
namespace Ngpictures\Controllers;


class MapsController extends Controller
{

    public function show()
    {
        $this->setLayout('blank-default');
        $this->viewRender('frontend/others/maps');
    }
}
