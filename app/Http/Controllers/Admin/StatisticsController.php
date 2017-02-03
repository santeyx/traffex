<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use App\News;

class StatisticsController extends Controller
{
    /**
     * Вывод общей статистики по дням
     * 
     * @return string
     */
    public function generals()
    {
        $redis = Redis::connection();
        
        $dates = $redis->zRange('statistics:generals', 0, -1, true);
        
        $data = [];
        
        foreach($dates as $key => $value) {
            $data[$key]['date'] = date('d-m-Y', $key);
            $data[$key]['hits'] = $redis->get('statistics:generals:' . $key . ':hits');
            $data[$key]['uniques_ip'] = ($redis->get('statistics:generals:' . $key . ':uniques_ip')) ? $redis->get('statistics:generals:' . $key . ':uniques_ip') : 0;
            $data[$key]['uniques_cookie'] = ($redis->get('statistics:generals:' . $key . ':uniques_cookie')) ? $redis->get('statistics:generals:' . $key . ':uniques_cookie') : 0;
        }
        
        return view('admin.statistics.generals', compact('data'));
    }
    
    /**
     * Вывод статистики по браузерам
     * 
     * @return string
     */
    public function browsers()
    {
        $redis = Redis::connection();
        
        $browsers = $redis->zRange('statistics:browsers', 0, -1, true);
        
        $data = [];
        
        foreach($browsers as $key => $value) {
            $data[$key]['browser'] = $key;
            $data[$key]['hits'] = $redis->get('statistics:browsers:' . md5($key) . ':hits');
            $data[$key]['uniques_ip'] = ($redis->get('statistics:browsers:' . md5($key) . ':uniques_ip')) ? $redis->get('statistics:browsers:' . md5($key) . ':uniques_ip') : 0;
            $data[$key]['uniques_cookie'] = ($redis->get('statistics:browsers:' . md5($key) . ':uniques_cookie')) ? $redis->get('statistics:browsers:' . md5($key) . ':uniques_cookie') : 0;
        }
        
        return view('admin.statistics.browsers', compact('data'));
    }
    
    /**
     * Вывод статистики по ОС
     * 
     * @return string
     */
    public function os()
    {
        $redis = Redis::connection();
        
        $browsers = $redis->zRange('statistics:os', 0, -1, true);
        
        $data = [];
        
        foreach($browsers as $key => $value) {
            $data[$key]['os'] = $key;
            $data[$key]['hits'] = $redis->get('statistics:os:' . md5($key) . ':hits');
            $data[$key]['uniques_ip'] = ($redis->get('statistics:os:' . md5($key) . ':uniques_ip')) ? $redis->get('statistics:os:' . md5($key) . ':uniques_ip') : 0;
            $data[$key]['uniques_cookie'] = ($redis->get('statistics:os:' . md5($key) . ':uniques_cookie')) ? $redis->get('statistics:os:' . md5($key) . ':uniques_cookie') : 0;
        }
        
        return view('admin.statistics.os', compact('data'));
    }
    
    /**
     * Вывод статистики по странам
     * 
     * @return string
     */
    public function geos()
    {
        $redis = Redis::connection();
        
        $browsers = $redis->zRange('statistics:geos', 0, -1, true);
        
        $data = [];
        
        foreach($browsers as $key => $value) {
            $data[$key]['geo'] = $key;
            $data[$key]['hits'] = $redis->get('statistics:geos:' . md5($key) . ':hits');
            $data[$key]['uniques_ip'] = ($redis->get('statistics:geos:' . md5($key) . ':uniques_ip')) ? $redis->get('statistics:geos:' . md5($key) . ':uniques_ip') : 0;
            $data[$key]['uniques_cookie'] = ($redis->get('statistics:geos:' . md5($key) . ':uniques_cookie')) ? $redis->get('statistics:geos:' . md5($key) . ':uniques_cookie') : 0;
        }
        
        return view('admin.statistics.geos', compact('data'));
    }
    
    /**
     * Вывод статистики по рефам
     * 
     * @return string
     */
    public function refs()
    {
        $redis = Redis::connection();
        
        $browsers = $redis->zRange('statistics:referers', 0, -1, true);
        
        $data = [];
        
        foreach($browsers as $key => $value) {
            $data[$key]['referer'] = $key;
            $data[$key]['hits'] = $redis->get('statistics:referers:' . md5($key) . ':hits');
            $data[$key]['uniques_ip'] = ($redis->get('statistics:referers:' . md5($key) . ':uniques_ip')) ? $redis->get('statistics:referers:' . md5($key) . ':uniques_ip') : 0;
            $data[$key]['uniques_cookie'] = ($redis->get('statistics:referers:' . md5($key) . ':uniques_cookie')) ? $redis->get('statistics:referers:' . md5($key) . ':uniques_cookie') : 0;
        }
        
        return view('admin.statistics.refs', compact('data'));
    }
    
    /**
     * Вывод статистики по новостям
     * 
     * @return string
     */
    public function news()
    {
        $redis = Redis::connection();
        
        $news = $redis->zRange('statistics:news', 0, -1, true);
        
        $data = [];
        
        foreach($news as $key => $value) {
            if ($news = News::find($key)) {
                $data[$key]['news'] = News::find($key);
                $data[$key]['hits'] = $redis->get('statistics:news:' . $key . ':hits');
                $data[$key]['uniques_ip'] = ($redis->get('statistics:news:' . $key . ':uniques_ip')) ? $redis->get('statistics:news:' . $key . ':uniques_ip') : 0;
                $data[$key]['uniques_cookie'] = ($redis->get('statistics:news:' . $key . ':uniques_cookie')) ? $redis->get('statistics:news:' . $key . ':uniques_cookie') : 0;
            }
        }
        
        return view('admin.statistics.news', compact('data'));
    }
}
