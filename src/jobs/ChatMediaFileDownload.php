<?php
/**
 * Created by PhpStorm.
 * User: lizhenning
 * Date: 17/01/2018
 * Time: 9:56 AM
 */

namespace Zning\EaseMobSdk\jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Bus\Queueable;
use Zning\EaseMobSdk\helper\Helper;
use Zning\EaseMobSdk\model\EaseMobChatMessage;


class ChatMediaFileDownload implements ShouldQueue
{
    use Queueable ,InteractsWithQueue, SerializesModels, Dispatchable;

    protected $chatMessage;
    protected $helper;


    /**
     * ChatMediaFileDownload constructor.
     * @param EaseMobChatMessage $chatMessage
     * @param Helper $helper
     *
     */


    public function __construct(EaseMobChatMessage $chatMessage, Helper $helper)
    {
        //
        $this->chatMessage = $chatMessage;
        $this->helper = $helper;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //

        $ext = 'jpg';

        if ($this->chatMessage->body_type == 'audio') {
            $ext = 'amr';
        }else if ($this->chatMessage->body_type == 'video') {
            $ext = 'mp4';
        }

        $file = $this->helper->downloadMediaFile($this->chatMessage->url, $this->chatMessage->secret, $ext);

        $this->chatMessage->body = $file;

        $this->chatMessage->status = 1;
        $this->chatMessage->save();

    }



}