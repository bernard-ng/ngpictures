<?php
namespace Ngpictures\Controllers;

class VersesController extends Controller
{

    public function index()
    {
        $this->loadModel('verses');
        $id = mt_rand(1, $this->verses->getVersesNumber());
        $verse = $this->verses->find($id);
        return $verse ?? null;
    }
}
