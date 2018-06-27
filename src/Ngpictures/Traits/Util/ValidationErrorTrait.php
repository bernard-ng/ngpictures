<?php
namespace Ngpictures\Traits\Util;


trait ValidationErrorTrait
{

    use RequestTrait;


    /**
     * envoyer les erreurs a une vue
     * @param string|null $msg
     * @return void
     */
    public function sendFormError(string $msg = null)
    {
        $errors = new Collection($this->validator->getErrors());
        $this->isAjax() ?
            $this->setFlash($errors->asJson(), 403) :
            $this->flash->set('danger', $this->flash->msg[$msg ?? 'form_multi_errors']);
    }
}
