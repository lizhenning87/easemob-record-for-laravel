<?php
/**
 * Created by PhpStorm.
 * User: lizhenning
 * Date: 17/01/2018
 * Time: 9:38 AM
 */

namespace Zning\EaseMobSdk\model;

use Illuminate\Database\Eloquent\Model;

class EaseMobChatMessage extends Model
{

    protected $table = 'easemob_chat_message';

    protected $fillable = [
        'timestamp',
        'to',
        'from',
        'chat_type',
        'body_type',
        'body',
        'secret',
        'url',
        'status',
        'msg_id',
        'filename',
        'json_original',
    ];

}