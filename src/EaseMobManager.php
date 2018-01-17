<?php
/**
 * Created by PhpStorm.
 * User: lizhenning
 * Date: 16/01/2018
 * Time: 2:49 PM
 */

namespace Zning\EaseMobSdk;

use Illuminate\Support\Facades\Schema;
use Zning\EaseMobSdk\events\ChatFileDownload;
use Zning\EaseMobSdk\exception\EaseMobException;
use Zning\EaseMobSdk\helper\Helper;
use Zning\EaseMobSdk\model\EaseMobChatMessage;

class EaseMobManager
{

    protected $config;
    protected $helper;

    public function __construct()
    {

    }


    public function setConfig($config) {

        if (!isset($config))
            throw new \Exception("请设置相关环信参数");

        $this->config = $config;

        foreach ($this->config as $key=>$value) {

            if (empty($value)) {

                throw new \Exception("请设置相关环信参数 [".$key."] 不能为空");
                break;
            }
        }

        $item = new EaseMobChatMessage;

        if (!Schema::hasTable($item->getTable())) {
            //
            throw new \Exception("请初始化数据库");
        }

        //初始化环信基本的帮助类
        $this->helper = new Helper($this->config);

    }

    public function version() {

        return 'version beta';
    }


    /**
     * @param $name
     * @param $pwd
     * @return mixed
     * @throws EaseMobException
     * 单用户注册
     *
     */

    function createUser($name, $pwd) {

        $result = $this->helper->createUser($name, $pwd);

        if (isset($result['error'])) {
            throw new EaseMobException(isset($result['error'])?$result['error']:'EaseMobSDK出错');
        }

        return $result;
    }


    /**
     * @param $time
     * @throws EaseMobException
     *
     * 获取聊天记录文件 时间格式:YmdH
     */

    function loadChatRecord($time) {

        $result = $this->helper->getChatHistory($time);

        if (isset($result['error'])) {
            throw new EaseMobException(isset($result['error'])?$result['error']:'EaseMobSDK出错');
        }

        //获取聊天记录文件成功，开始下载
        $data = $result['data'];

        event(new ChatFileDownload($data, $this->helper));

    }


    /**
     * @param int $hour
     * @throws EaseMobException
     *
     * 获取当前时间之前聊天记录文件
     *
     */

    function loadChatRecordBeforeNow($hour = 2) {

        $time= date("YmdH", strtotime("-$hour hour"));

        var_dump($time);
        return $this->loadChatRecord($time);
    }


    /**
     * @return mixed
     *
     * 获取环信SDK
     */

    function easeMobSDK() {

        return $this->helper;
    }

}