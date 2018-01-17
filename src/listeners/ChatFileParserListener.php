<?php

namespace Zning\EaseMobSdk\listeners;


use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;
use Zning\EaseMobSdk\events\ChatFileParser;
use Zning\EaseMobSdk\jobs\ChatMediaFileDownload;
use Zning\EaseMobSdk\model\EaseMobChatMessage;


class ChatFileParserListener
{
    use DispatchesJobs;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //

    }

    /**
     * Handle the event.
     *
     * @param  ChatFileParser  $event
     * @return void
     */
    public function handle(ChatFileParser $event)
    {
        //
        $helper = $event->helper;
        $path = $event->path;

        $file = $this->readGZ($path);

        $array = explode("\n", $file);

        foreach ($array as $temp) {

            $status = 1;

            if ($temp == '') {

            }else {

                $item = json_decode($temp, true);

                $body_type = $item['payload']['bodies'][0]['type'];
                $body = '';
                $secret = '';
                $url = '';
                $fileName = '';

                if ($body_type == 'img' || $body_type == 'audio' || $body_type == 'video' || $body_type == 'file') {

                    $status = 2;
                    $secret = $item['payload']['bodies'][0]['secret'];
                    $url = $item['payload']['bodies'][0]['url'];
                    $fileName = $item['payload']['bodies'][0]['filename'];

                }else if ($body_type == 'loc'){

                    $body = $item['payload']['bodies'][0]['addr'].';'.$item['payload']['bodies'][0]['lat'].';'.$item['payload']['bodies'][0]['lng'];

                }else {

                    $body = $item['payload']['bodies'][0]['msg'];
                }

                $sql = [
                    'msg_id' => $item['msg_id'],
                    'timestamp' => $item['timestamp'],
                    'to' => $item['to'],
                    'from' => $item['from'],
                    'chat_type' => $item['chat_type'],
                    'body_type' => $body_type,
                    'body' => $body,
                    'secret' => $secret,
                    'url' => $url,
                    'status' => $status,
                    'filename' => $fileName,
                    'json_original' => $temp,
                ];

                try {

                    $model = new EaseMobChatMessage();

                    $model->fill($sql);

                    $model->save();

                    if ($status == 2) {

                        //发送到下载媒体队列
                        $this->dispatch(new ChatMediaFileDownload($model, $helper));

                    }


                }catch (\Exception $e) {

                    Log::info($e);

                }

            }

        }


    }

    function readGZ($path) {

        $buffer_size = 4096;

        $file = gzopen($path, 'rb');

        $str = '';

        while (!gzeof($file)) {
            $str .= gzread($file, $buffer_size);
        }

        gzclose($file);

        return $str;
    }
}
