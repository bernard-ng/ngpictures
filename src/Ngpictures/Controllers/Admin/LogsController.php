<?php
namespace Ngpictures\Controllers\Admin;

use Ng\Core\Managers\ConfigManager;
use Ng\Core\Managers\LogMessageManager;
use Ng\Core\Managers\Mailer\Mailer;
use Ngpictures\Controllers\AdminController;
use RuntimeException;

class LogsController extends AdminController
{

    /**
     * affiche les erreurs grace au logMessageManager
     */
    public function index()
    {
        $logs = (is_file(ROOT."/system.log")) ? file_get_contents(ROOT."/system.log") : "file: system-log not found";
        $this->turbolinksLocation(ADMIN.'/logs');
        $this->pageManager::setTitle('Adm - Logs');
        $this->view('backend/logs', compact('logs'));
    }


    /**
     * supprimer les erreurs logs, renitialise
     *
     * @return void
     */
    public function clear()
    {
        LogMessageManager::clear();
        $this->flash->set("success", $this->flash->msg['success']);
        $this->redirect(true);
    }


    /**
     * envoyer les logs a l'admin par mail
     *
     * @return void
     */
    public function send()
    {
        $email = $this->container->get('site.email');

        try {
            $this->container->get(Mailer::class)->sendLogs($email);
            $this->flash->set("success", $this->flash->msg['success'], false);
            $this->redirect(true, false);
        } catch (RuntimeException $e) {
            LogMessageManager::register(__class__, $e);
            $this->flash->set('danger', $this->flash->msg['undefined_error'], false);
            $this->redirect(true, false);
        }
    }
}
