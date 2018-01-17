<?php

namespace Zning\EaseMobSdk\events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ChatFileDownload
{
    use SerializesModels;

    public $urls;
    public $helper;


    /**
     * ChatFileDownload constructor.
     * @param $urls
     * @param $helper
     */

    public function __construct($urls, $helper)
    {
        //
        $this->urls = $urls;
        $this->helper = $helper;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}
