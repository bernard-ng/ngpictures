<?php
/**
 * Created by PhpStorm.
 * User: BERNQRD NG
 * Date: 05/05/2018
 * Time: 03:54
 */

namespace Ngpictures\Controllers;

class StaticController extends Controller
{
    public function about()
    {
        $this->app::turbolinksLocation("/about");
        $this->setLayout("posts/default");
        $this->pageManager::setName("A Propos de nous");
        $this->viewRender('front_end/others/about');
    }
}
