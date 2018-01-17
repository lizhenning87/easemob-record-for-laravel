<?php

namespace Zning\EaseMobSdk\events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ChatFileParser
{
    use SerializesModels;

    public $path;
    public $helper;

    /**
     * ChatFileParser constructor.
     * @param $path
     * @param $helper
     */
    public function __construct($path, $helper)
    {
        //
        $this->path = $path;
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
