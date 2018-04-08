<?php
namespace Ngpictures\Controllers;

class VersesController extends Controller
{

    public function index()
    {
        $this->loadModel('verses');
        $max = $this->verses->getVersesNumber();

        if ($max >= 1) {
            $id = mt_rand(1, $max);
            $verse = $this->verses->find($id);
            return $verse ?? null;
        }
    }
}
