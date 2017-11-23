<?php


namespace Ngpic\Model;

use Core\Model\Model;


/**
 * class Article
 * FR - permet de gèrer les articles du site
 * EN - this class administrates all the website articles
 * @package Ngpic\Model
 * @author Bernard ng
 **/
class ArticlesModel extends Model
{

    protected $table = "articles";


    public function lastByUser($user_id)
    {
        return $this->query("SELECT * FROM {$this->table} WHERE user_id = ? ORDER BY date_created DESC",[$user_id]);
    }


    public function lastByCategory($category_id)
    {
        return $this->query("SELECT * FROM {$this->table} WHERE category_id = ?",[$category_id]);
    }


   
























}
