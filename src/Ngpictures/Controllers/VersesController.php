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
        $max = $this->verses->getVersesNumber()->numbers;

        if ($max >= 1) {
            $id = mt_rand(1, $max);
            $verse = $this->verses->find($id);

            if ($this->isAjax()) {
                if (isset($_GET['option']) && !empty($_GET['option'])) {
                    $verse = [
                        "txt" => $verse->text,
                        "ref" => implode(' ', explode('.', $verse->ref)),
                        "id" => $verse->id
                    ];
                    echo json_encode($verse);
                }
            }
            return $verse;
        }
        return null;
    }
}
