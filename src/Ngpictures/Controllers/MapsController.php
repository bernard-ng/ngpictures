<?php
namespace Ngpictures\Controllers;


class MapsController extends Controller
{

    public function show()
    {
        $this->viewRender('frontend/others/maps');
    }
}
