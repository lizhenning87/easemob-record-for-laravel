<?php
/**
 * Created by PhpStorm.
 * User: lizhenning
 * Date: 16/01/2018
 * Time: 2:46 PM
 */

namespace Zning\EaseMobSdk;

use Illuminate\Support\Facades\Facade;

class EaseMob extends Facade
{

    public static function getFacadeAccessor()
    {
        return 'easemob';
    }

}