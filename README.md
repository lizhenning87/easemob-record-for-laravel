# easemob-record-for-laravel

> 封装环信PHPSDK，获取并解析环信服务器上的历史消息

### Feature
 1. [x] 获取聊天记录文件，解析入库
 2. [x] 下载聊天中的媒体文件
 
 
 
 ### 1. 安装 EasemobSDK
 
 在控制台中运行此命令
 
 ```
 
 composer require zning/easemobsdk
 
 ```
 
 此命令运行后将会自动更新 `composer.json` 文件，并将扩展包安装在`vendor/`目录中
 
 
 ### 2. 配置 EasemobSDK
 
 在项目config文件夹中，找到app.php
 
 编辑如下对应内容
 
 找到`providers`数组，添加 `\Zning\EaseMobSdk\EaseMobProvider::class,`
 
 ```
 'providers' => 
 [
     \Zning\EaseMobSdk\EaseMobProvider::class,
 ]
 
 ```
 
 找到`aliases`数组，添加
 `'EaseMob' => \Zning\EaseMobSdk\EaseMob::class,`
 
 ```
 
 'aliases' => 
 [
    'EaseMob' => \Zning\EaseMobSdk\EaseMob::class,
 ]
 
 ```
 
 ### 3. 发布 EasemobSDK
 
 在控制台中运行此命令
 
 ```
 
 php artisan vendor:publish
 
 ```
 
 
 此命令运行后会自动在config文件夹中生成easemob.php配置文件
 
  
 ### 4. EasemobSDK 配置文件
 
 ##### 1. 打开easemob.php配置文件,配置相关参数
 
 ```
 
     return [
     
         //环信相关参数
         'client_id' => '',
         'client_secret' => '',
         'org_name' => '',
         'app_name' => '',
         
         //聊天记录文件保存路径
         'record_path' => '', 
         
         //聊天记录媒体文件保存路径
         'record_media_path' => '', 
     ];
 
 
 ```
 
  ##### 2. 配置EventServiceProvider.php文件，内容如下
 
  ```
  
      protected $listen = [
      
          'App\Events\Event' => [
              'App\Listeners\EventListener',
          ],
          
          
          ChatFileDownload::class => [
              ChatFileDownloadListener::class,
          ],
          
          
          ChatFileParser::class => [
              ChatFileParserListener::class,
          ],
          
      ];
  
  ```
 
  ##### 3. 启用Laravel队列
 
  ```
  
     如果您的项目中已实用Laravel队列，则无需配置
  
     php artisan queue:table
  
  ```
  
 
  ##### 4. 执行数据迁移命令
 

```

    php artisan migrate 

```