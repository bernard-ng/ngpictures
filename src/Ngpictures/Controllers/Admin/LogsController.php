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
        $logs = (is_file(ROOT."/system.log"))
            ? file_get_contents(ROOT."/system.log")
            : "file: system-log not found";

        $this->pageManager::setName('Adm - Logs');
        $this->setLayout("admin/default");
        $this->viewRender('back_end/logs', compact('logs'));
    }


    /**
     * supprimer les erreurs logs, renitialise
     *
     * @return void
     */
    public function clear()
    {
        LogMessageManager::clear();
        $this->flash->set("success", $this->msg['success']);
        $this->app::redirect(true);
    }


    /**
     * envoyer les logs a l'admin par mail
     *
     * @return void
     * @throws \Ng\Core\Exception\ConfigManagerException
     */
    public function send()
    {
        $email = (new ConfigManager(ROOT."/config/SystemConfig.php"))->get('site.email');

        try {
            (new Mailer())->sendLogs($email);
            $this->flash->set("success", $this->msg['success']);
            $this->app::redirect(true);
        } catch (RuntimeException $e) {
            $this->flash->set('danger', $this->msg['undefined_error']);
            $this->app::redirect(true);
        }
    }
}