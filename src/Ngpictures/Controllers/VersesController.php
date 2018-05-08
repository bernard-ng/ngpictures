<?php
namespace Ngpictures\Controllers;


class VersesController extends Controller
{

    /**
     * renvoi un verse.
     * @return null|string
     *
     */
    public function index()
    {
        $this->loadModel('verses');
        $max = $this->verses->getVersesNumber();

        if ($max >= 1) {
            $id = mt_rand(1, $max);
            $verse = $this->verses->find($id);

            if ($this->isAjax()) {
                $verse = [
                    "txt" => $verse->text,
                    "ref" => implode(' ',explode('.', $verse->ref)),
                    "id" => $verse->id
                ];
                echo json_encode($verse);
            }
            return $verse;
        }
        return null;
    }
}
