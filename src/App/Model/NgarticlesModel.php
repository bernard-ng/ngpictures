<?php


namespace Ngpic\Model;

use Core\Model\Model;


/**
 * Class Ngarticles
 * FR - administre les articles du site
 * EN - administrates website articles
 * @package Ngpic\Model
 * @author Bernard ng
 */
class NgarticlesModel extends Model{


    protected $table = "ng_articles";

 
    public function lastByCategory($category_id)
    {
        return $this->query("SELECT * FROM {$this->table} WHERE category_id = ?",$category_id);
    }

}