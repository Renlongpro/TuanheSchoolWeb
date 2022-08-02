<?php
    function ChangeJson($path,$ElenName,$NewNum){
        $json_string = file_get_contents($path);// 从文件中读取数据到PHP变量
        $data = json_decode($json_string);// 把JSON字符串转成PHP对象
        $data -> $ElenName = $NewNum;
        $json_strings = json_encode($data);
        file_put_contents($path,$json_strings);
    }
    function Task_start(){
        ChangeJson(__DIR__."/Config.json","TaskRun",true);
        echo "OK";
        fastcgi_finish_request();
        TaskRun();
    }
    function Task_end(){
        ChangeJson(__DIR__."/Config.json","TaskRun",false);
        fastcgi_finish_request();
        echo "OK";
    }
    function TaskRun(){
        $json_string = file_get_contents(__DIR__."/Config.json");
        $data = json_decode($json_string);
        if($data -> TaskRun);
        else{
            $log=fopen(__DIR__."/LOG/".date('Y-m-d_', time())."TaskRun.log","a");
            fwrite($log,date('[Y-m-d H:i:s]', time())."TaskRun is Exit."."\n");
            fclose($log);
        }
        if($data -> KeepAliveT == 0){
            $data -> KeepAliveT = 1;
            $json_strings = json_encode($data);
            file_put_contents(__DIR__."/Config.json",$json_strings);
        }
        $FileList=scandir(__DIR__.'/TaskIng/');
        foreach($FileList as $fileName){
            if ($fileName !="." and $fileName !=".."){
                $TaskCode=file_get_contents(__DIR__."/TaskIng/".$fileName);
                $TaskCode="try{".$TaskCode."}".
                        "catch(Exception \$error){
                            return 'Error :'.\$error;
                        }";
                fwrite($log,date('[Y-m-d H:i:s]', time())."TaskRun ".$fileName);
                $result=eval($TaskCode);
                fwrite($log,"||result >> ".$result);
                unlink(__DIR__."/TaskIng/".$fileName);
            }
        }
        sleep(10);
        TaskRun();
    }
    ignore_user_abort(true);
    set_time_limit(0);
    $log=fopen(__DIR__."/LOG/".date('Y-m-d_', time())."TaskRun.log","a");
    if($_GET['task']!=""){
        switch($_GET['task']){
            case 1: //start
                Task_start();
                break;
            case 2: //end
                Task_end();
        }
    }
?>