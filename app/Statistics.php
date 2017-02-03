<?php

namespace App;

use Illuminate\Support\Facades\Redis;

class Statistics
{
    /**
     * Запуск сбора статистики
     * 
     * @param int $news_id
     */
    public static function process($news_id=0)
    {
        $current_date = self::getCurrentDayTimestamp();
        $browser = self::getBrowser();
        $os = self::getPlatform();
        $geo = self::getGeo();
        $referer = self::getRefererHost();
        
        $redis = Redis::connection();
        
        //Собираем по датам
        $redis->zAdd('statistics:generals', [$current_date]);
        //Собираем Хиты
        $redis->incr('statistics:generals:' . $current_date . ':hits');
        
        //Собираем по браузерам
        $redis->zAdd('statistics:browsers', [$browser]);
        //Собираем Хиты
        $redis->incr('statistics:browsers:' . md5($browser) . ':hits');
        
        //Собираем по осям
        $redis->zAdd('statistics:os', [$os]);
        //Собираем Хиты
        $redis->incr('statistics:os:' . md5($os) . ':hits');
        
        //Собираем по странам
        $redis->zAdd('statistics:geos', [$geo['country_code']]);
        //Собираем Хиты
        $redis->incr('statistics:geos:' . md5($geo['country_code']) . ':hits');
        
        if (isset($referer)) {
            //Собираем по рефам
            $redis->zAdd('statistics:referers', [$referer]);
            //Собираем Хиты
            $redis->incr('statistics:referers:' . md5($referer) . ':hits');
        }
        
        if (!empty($news_id)) {
            //Собираем по новостям
            $redis->zAdd('statistics:news', [$news_id]);
            //Собираем Хиты
            $redis->incr('statistics:news:' . $news_id . ':hits');
        }
        
        //Уники по Ip
        if (self::isVisitorUnique($news_id)) {
            //Собираем за текущую дату
            $redis->incr('statistics:generals:' . $current_date . ':uniques_ip');

            //Собираем по браузерам
            $redis->incr('statistics:browsers:' . md5($browser) . ':uniques_ip');

            //Собираем по осям
            $redis->incr('statistics:os:' . md5($os) . ':uniques_ip');
            
            //Собираем по странам
            $redis->incr('statistics:geos:' . md5($geo['country_code']) . ':uniques_ip');
            
            if (isset($referer)) {
                //Собираем по рефам
                $redis->incr('statistics:referers:' . md5($referer) . ':uniques_ip');
            }
            
            if (!empty($news_id)) {
                //Собираем по новостям
                $redis->incr('statistics:news:' . $news_id . ':uniques_ip');
            }
        }
        
        //Уники по Cookie
        if (self::isVisitorUniqueCookie($news_id)) {
            //Собираем за текущую дату
            $redis->incr('statistics:generals:' . $current_date . ':uniques_cookie');

            //Собираем по браузерам
            $redis->incr('statistics:browsers:' . md5($browser) . ':uniques_cookie');

            //Собираем по осям
            $redis->incr('statistics:os:' . md5($os) . ':uniques_cookie');
            
            //Собираем по странам
            $redis->incr('statistics:geos:' . md5($geo['country_code']) . ':uniques_cookie');
            
            if (isset($referer)) {
                //Собираем по рефам
                $redis->incr('statistics:referers:' . md5($referer) . ':uniques_cookie');
            }
            
            if (!empty($news_id)) {
                //Собираем по новостям
                $redis->incr('statistics:news:' . $news_id . ':uniques_cookie');
            }
        }
    }
    
    /**
     * Получение браузера
     *
     * @return string
     */
    public static function getBrowser()
    {
        if (isset($_SERVER['HTTP_USER_AGENT'])) {
            $user_agent = $_SERVER['HTTP_USER_AGENT'];

            if (strpos($user_agent, 'Opera') !== false || strpos($user_agent, 'OPR/')) {
                return 'Opera';
            } elseif (strpos($user_agent, 'Maxthon') || strpos($user_agent, 'MAXTHON')) {
                return 'Maxthon';
            } elseif (strpos($user_agent, 'Edge')) {
                return 'Edge';
            } elseif (strpos($user_agent, 'Amigo')) {
                return 'Amigo';
            } elseif (strpos($user_agent, 'Version/') && strpos($user_agent, 'Android')) {
                return 'Android';
            } elseif (strpos($user_agent, 'YaBrowser')) {
                return 'Yandex';
            } elseif (strpos($user_agent, 'Chrome')) {
                return 'Chrome';
            } elseif (strpos($user_agent, 'Safari')) {
                return 'Safari';
            } elseif (strpos($user_agent, 'Firefox')) {
                return 'Firefox';
            } elseif (strpos($user_agent, 'MSIE') || strpos($user_agent, 'Trident/7')) {
                return 'Internet Explorer';
            }
        }

        return 'Other';
    }
    
    /**
     * Получение платформы (ОС)
     *
     * @return string
     */
    public static function getPlatform()
    {
        if (isset($_SERVER['HTTP_USER_AGENT'])) {
            $user_agent = $_SERVER['HTTP_USER_AGENT'];

            if (strpos($user_agent, 'Android')) {
                return 'Android';
            } elseif (strpos($user_agent, 'CrOS')) {
                return 'ChromeOS';
            } elseif (strpos($user_agent, 'Linux') || strpos($user_agent, 'X11;')) {
                return 'Linux';
            } elseif (strpos($user_agent, 'Windows Mobile') || strpos($user_agent, 'Windows Phone')) {
                return 'WindowsMobile';
            } elseif (strpos($user_agent, 'iPad') || strpos($user_agent, 'iPod') || strpos($user_agent, 'iPhone')) {
                return 'iOS';
            } elseif (strpos($user_agent, 'Macintosh') || strpos($user_agent, 'Mac OS X')) {
                return 'MAC';
            } elseif (strpos($user_agent, 'Windows')) {
                return 'Windows';
            } elseif (strpos($user_agent, 'SymbianOS') || strpos($user_agent, 'Series 60') || strpos($user_agent, 'SymbOS')) {
                return 'SymbianOS';
            } elseif (strpos($user_agent, 'Nokia') || strpos($user_agent, 'Series')) {
                return 'NokiaSeries';
            } elseif (strpos($user_agent, 'Bada')) {
                return 'Bada';
            } elseif (strpos($user_agent, 'BlackBerry') || strpos($user_agent, 'RIM')) {
                return 'BlackBerryOS';
            } elseif (strpos($user_agent, 'Philips') || strpos($user_agent, 'PHILIPS')) {
                return 'Philips';
            } elseif (strpos($user_agent, 'Mobile;') || strpos($user_agent, 'Tablet;')) {
                return 'FirefoxOS';
            }
        }

        return 'Other';
    }
    
    /**
     * Получаем хост реферера
     * 
     * @return string
     */
    public static function getRefererHost()
    {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $referer = $_SERVER['HTTP_REFERER'];
            $referer_host = parse_url($referer, PHP_URL_HOST);
        } else {
            $referer_host = NULL;
        }
        
        return $referer_host;
    }
    
    /**
     * Получаем User Agent
     * 
     * @return string
     */
    public static function getUserAgent()
    {
        if (isset($_SERVER['HTTP_USER_AGENT'])) {
            $user_agent = $_SERVER['HTTP_USER_AGENT'];
        } else {
            $user_agent = 'UNKNOWN';
        }
        
        return $user_agent;
    }
    
    /**
     * Получение инфорамции о стране
     *
     * @return array
     */
    public static function getGeo() {
        $data = [
            'country_code' => 'UNKNOWN',
            'user_ip' => '0.0.0.0',
            'user_ip_int' => 0
        ];

        if (isset($_SERVER['GEOIP_COUNTRY_CODE'])) {
            $data['country_code'] = $_SERVER['GEOIP_COUNTRY_CODE'];
        }

        if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $temp = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
            $temp = end($temp);
            $data['user_ip'] = trim($temp);
        } elseif (isset($_SERVER['REMOTE_ADDR'])) {
            $data['user_ip'] = trim($_SERVER['REMOTE_ADDR']);
        }

        $data['user_ip_int'] = sprintf('%u', ip2long($data['user_ip']));

        return $data;
    }
    
    /**
     * Получение дня недели (пн - 1, ...,  вс - 7)
     *
     * @return int
     */
    public static function getWeekday()
    {
        return date('N');
    }

    /**
     * Получение часов (00, ..., 23)
     *
     * @return string
     */
    public static function getHour()
    {
        return date('H');
    }

    /**
     * Unix timestamp для текущего дня
     *
     * @return int
     */
    public static function getCurrentDayTimestamp()
    {
        return mktime(0, 0, 0, date('m'), date('d'), date('Y'));
    }
    
    /**
     * Формируем уникальный идентификатор пользователя по указанным строковым данным
     *
     * @param string $ip
     * @param string $ua
     * 
     * @return string
     */
    public static function getUserIdByString($ip, $ua)
    {
        return md5('UID:' . $ip . $ua);
    }
    
    /**
     * Проверяем юзера на уникальность по Ip
     * 
     * @param int $news_id
     * 
     * @return bool;
     */
    public static function isVisitorUnique($news_id=0)
    {
        $geo = self::getGeo();
        $ua = self::getUserAgent();
        
        $user_id = self::getUserIdByString($geo['user_ip'], $ua);
        
        $redis = Redis::connection();
        
        if (empty($news_id)) {
            if ($redis->get('visitors:uniques:' . $user_id)) {
                return FALSE;
            } else {
                setcookie("user_id", $user_id, time()+86400, '/');
                $redis->set('visitors:uniques:' . $user_id, 86400);
            
                return TRUE;
            }
        } else {
            if ($redis->get('visitors:' . $news_id . ':uniques:' . $user_id)) {
                return FALSE;
            } else {
                setcookie("news_id[" . $news_id . "]", $user_id, time()+86400, '/news/');
                $redis->set('visitors:' . $news_id . ':uniques:' . $user_id, 86400);
            
                return TRUE;
            }
        }
        
    }
    
    /**
     * Проверяем юзера на уникальность по Cookie
     * 
     * @param int $news_id
     * 
     * @return bool;
     */
    public static function isVisitorUniqueCookie($news_id=0)
    {
        if (empty($news_id)) {
            if (isset($_COOKIE['user_id'])) {
                return FALSE;
            }
        } else {
            if (isset($_COOKIE['news_id'])) {
                foreach ($_COOKIE['news_id'] as $key => $value) {
                    if ($key == $news_id) {
                        return FALSE;
                    }
                }
            }
        }
        
        return TRUE;
    }

}
