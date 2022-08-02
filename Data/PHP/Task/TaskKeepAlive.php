<?php
    function ChangeJson($path,$ElenName,$NewNum){
        $json_string = file_get_contents($path);// 从文件中读取数据到PHP变量
        $data = json_decode($json_string);// 把JSON字符串转成PHP对象
        $data -> $ElenName = $NewNum;
        $json_strings = json_encode($data);
        file_put_contents($path,$json_strings);
    }
    function KeepreadConfig(){
        $json_string = file_get_contents(__DIR__."/Config.json");
        $data = json_decode($json_string);
        return $data;
    }
    $log=fopen(__DIR__."/LOG/".date('Y-m-d_', time())."TaskRun.log","a");
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "http://www.tuanheschool.xyz/Data/PHP/Task/Task.php?task=1");  
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, false);
    curl_setopt($ch,CURLOPT_TIMEOUT,3);
    $data = KeepreadConfig();
    while($data -> TaskRun){
        ChangeJson(__DIR__."/Config.json","KeepAliveT",0);
        sleep(60);
        $data = KeepreadConfig();
        if($data -> KeepAliveT != 1){
            fwrite($log,date('[Y-m-d H:i:s]', time())."Start Task\n");
            curl_exec($ch);
        }
    }
?>