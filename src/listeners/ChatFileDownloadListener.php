<?php
/**
 * Created by PhpStorm.
 * User: lizhenning
 * Date: 16/01/2018
 * Time: 5:44 PM
 */

namespace Zning\EaseMobSdk\listeners;


use Zning\EaseMobSdk\events\ChatFileDownload;
use Zning\EaseMobSdk\events\ChatFileParser;

class ChatFileDownloadListener
{

    public function __construct()
    {
    }


    public function handle(ChatFileDownload $event)
    {

        $urls = $event->urls;
        $helper = $event->helper;

        foreach ($urls as $item) {

            $url = $item['url'];

            //下载聊天记录文件
            $result = $helper->downloadRecordFile($url);

            event(new ChatFileParser($result, $helper));

        }

    }

}