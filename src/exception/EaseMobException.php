<?php
/**
 * Created by PhpStorm.
 * User: lizhenning
 * Date: 16/01/2018
 * Time: 5:13 PM
 */

namespace Zning\EaseMobSdk\exception;


class EaseMobException extends \Exception
{
    public function __construct($message, $code = 0) {
        parent::__construct($message, $code);
    }

    public function __toString() {
        return __CLASS__.':['.$this->code.']:'.$this->message.'\n';
    }

}