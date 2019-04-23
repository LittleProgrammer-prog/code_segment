/**
* laravel的代码是分级别的特性，有时在测试时代码数据有时混乱，所以写个代码片段用户测试时使用（不要放线上毕竟性能没有框架自带的号）
* 可以将改代码放在app\Helpers\functions.php中
*
* $messagelog中准备记录的数据
* $logname存储的log名
*/

function Plog($message=null, $logname)
{
    // 将log文件放在storage的logs下
    $savepath = storage_path('logs/customize/');

    if (!is_dir($savepath)) {
    mkdir($savepath, 0777, true);
    }

    // 获取基本信息
    $runtime = round(microtime(true) - LARAVEL_START, 10);  // 代码运行时间
    $reqs    = $runtime > 0 ? number_format(1 / $runtime, 2) : '∞';     // 吞吐率
    $time_str = '[运行时间：' . number_format($runtime, 6) . 's] [吞吐率：' . $reqs . 'req/s]';

    $date = date('Y-m-d H:i:s', time());
    $data = $date .' '.$time_str.': '. json_encode($message) . "\r\n";

    file_put_contents($savepath.$logname, $data,FILE_APPEND);
}