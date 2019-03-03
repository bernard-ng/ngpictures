<?php
namespace Application\Traits\Util;

use Framework\Managers\Collection;

trait ValidationErrorTrait
{

    public function sendFormError()
    {
        $errors = new Collection($this->validator->getErrors());
        $this->isAjax() ?
            $this->setFlash($errors->asJson(), 403) :
            $this->flash->set('danger', $this->flash->msg[$msg ?? 'form_multi_errors'], false);
    }
}
