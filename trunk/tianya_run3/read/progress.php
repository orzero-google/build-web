<?php  
/** 
 * 进度条
 *  
 */  
  
function ExecTime()  
{  
    $time = explode(" ", microtime());  
    $usec = (double)$time[0];  
    $sec = (double)$time[1];  
    return $sec + $usec;  
}  
  
function ShowMsg($msg, $gourl, $onlymsg = 0, $limittime = 0) {  
    if (empty ( $GLOBALS ['cfg_phpurl'] )) {  
        $GLOBALS ['cfg_phpurl'] = '..';  
    }  
    $htmlhead = "<html><head><meta http-equiv=\"content-type\" content=\"text/html; charset=utf-8\" />
    <title> 系统提示信息</title><meta http-equiv=\"Content-Type\" content=\"text /html; charset=gb2312\" />";  
    $htmlhead .= "<base target='_self'/><style>div{line-height:160%;}</style></head><body leftmargin='0' topmargin='0'><center><script>";  
    $htmlfoot = "</script></center></body></html>";  
      
    if ($limittime == 0) {  
        $litime = 1000;  
    } else {  
        $litime = $limittime;  
    }  
      
    if ($gourl == "-1") {  
        if ($limittime == 0) {  
            $litime = 5000;  
        }  
        $gourl = "javascript:history.go(-1);";  
    }  
      
    if ($gourl == '' || $onlymsg == 1) {  
        $msg = "<script>alert(\"" . str_replace ( "\"", "“", $msg ) . "\");</script>";  
    } else {  
        $func = "      var pgo=0; 
      function JumpUrl(){ 
        if(pgo==0){ location='$gourl'; pgo=1; } 
      }";  
        $rmsg = $func;  
        $rmsg .= "document.write(\"<br /><div style='width:450px;padding:0px;border:1px solid #D1DDAA;'>";  
        $rmsg .= "<div style='padding:6px; font-size:12px;border- bottom:1px solid #D1DDAA;background:#DBEEBD url({$GLOBALS['cfg_phpurl']}/img /wbg.gif)';'><b>系统提示信息！</b></div>\");";  
        $rmsg .= "document.write(\"<div style='height:130px;font-size:10pt;background:#ffffff'><br />\");";  
        $rmsg .= "document.write(\"" . str_replace ( "\"", "“", $msg ) . "\");";  
        $rmsg .= "document.write(\"";  
        if ($onlymsg == 0) {  
            if ($gourl != "javascript:;" && $gourl != "") {  
                $rmsg .= "<br /><a href='{$gourl}'>如果你的浏览器没反应，请点击这里...</a>";  
            }  
            $rmsg .= "<br/></div>\");";  
            if ($gourl != "javascript:;" && $gourl != '') { 
                $rmsg .= "setTimeout('JumpUrl()',$litime);"; 
            } 
        } else { 
            $rmsg .= "<br/><br/></div>\");"; 
        } 
        $msg = $htmlhead . $rmsg . $htmlfoot; 
    } 
    echo $msg; 
} 
 
 
 
$est1 = ExecTime(); 
foreach ($_GET as $k => $v) { 
    $$k=$v; 
} 
 
 
$startid  = (empty($startid)  ? 0  : $startid);//开始数量 
$endid    = (empty($endid)    ? 0  : $endid);//结束数量 
$pagesize = (empty($pagesize) ? 1 : $pagesize);//每次执行条数 
$totalnum = (empty($totalnum) ? 0  : $totalnum);//总数量 
 
$seltime  = (empty($seltime)  ? 0  : $seltime); 
$stime    = (empty($stime)    ? '' : $stime ); 
$etime    = (empty($etime)    ? '' : $etime); 
$sstime   = (empty($sstime)   ? 0  : $sstime);  
$successnum  = (empty($successnum)  ? 0  : $successnum);//成功数量 
//处理业务逻辑 
if ($totalnum==0) $totalnum=100; 
//空转1000000次  爽吧？！！ 
for ($i = 0; $i < 1000000; $i++) {      
    //请在这里执行发送代码 
}    
$startid=$startid+$pagesize; 
$successnum++; 
 
if(empty($sstime)) { 
    $sstime = time(); 
}   
   
$t2 = ExecTime(); 
$t2 = ($t2 - $est1); 
$ttime = time() - $sstime; 
$ttime = number_format(($ttime / 60),2); 
 
//返回提示信息 
$tjlen = $totalnum>0 ? ceil( ($startid/$totalnum) * 100 ) : 100;//当前进度 
$dvlen = $tjlen * 4; 
$tjsta = "<div style='width:400;height:15;border:1px solid #898989;text-align:left'><div style='width:$dvlen;height:15;background-color:#829D83'></div></div>";  
$tjsta .= "<br/>本次用时：".number_format($t2,2)."，总用时：$ttime 分钟，总任务：".($totalnum).",到达位置：".($startid)."<br/>完成创建文件总数的：$tjlen %，继续执行任务...";  
//$tjsta .= "<br/>";  
//$tjsta .= "<br/>本次执行的任务表述";  
  
if($startid < $totalnum)  
{  
    $nurl  = "?endid=$endid&startid=$startid";  
    $nurl .= "&totalnum=$totalnum&pagesize=$pagesize";  
    $nurl .= "&seltime=$seltime&sstime=$sstime&stime=".urlencode($stime)."&etime=".urlencode($etime)."&successnum=$successnum&mkvalue=$mkvalue";  
    ShowMsg($tjsta,$nurl,0,1000);  
    exit();  
}  
else  
{  
    ShowMsg("完成所有任务！，生成发送：$successnum 总用时：{$ttime} 分钟。","javascript:;");  
}  
  
?> 