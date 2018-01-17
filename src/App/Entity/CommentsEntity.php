<?php
namespace Ngpictures\Entity;


use Ngpictures\Ngpictures;
use Ng\Core\Entity\Entity;


class CommentsEntity extends Entity
{

    /**
     * la session pour les token
     * @var \Ng\Core\Generic\Session
     */
    private $session;


    /**
     * les membres pour les actions
     * @var mixed
     */
    private $users;


    /**
     * va charger la session et le model des users
     * CommentsEntity constructor.
     */
	public function __construct()
	{
		$this->users = Ngpictures::getInstance()->getModel('users');
		$this->session = Ngpictures::getInstance()->getSession();
	}


    /**
     * permet de supprimer un commentaire
     * @return string
     */
	public function getDeleteUrl()
	{
		return "/comments/delete/{$this->id}/{$this->session->read(TOKEN_KEY)}";
	}


    /**
     * permet d'editer un commentaire
     * @return string
     */
	public function getEditUrl()
	{
		return "/comments/edit/{$this->id}/{$this->session->read(TOKEN_KEY)}";
	}
}
