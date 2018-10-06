<?php

namespace yii2lab\extension\web\helpers;

use InvalidArgumentException;
use Yii;
use yii2lab\domain\data\GetParams;
use xj\ua\UserAgent;
use yii\web\View;
use yii2lab\domain\data\Query;

class ClientHelper
{

	const IP_HEADER_KEY = 'ip_address';
	const LOCALHOST_IP = '127.0.0.1';

    public static function setLocalStorage($key, $value) {
        $code = 'localStorage.setItem("' . $key . '", ' . json_encode($value) . ');';
        self::runJavasriptCode($code);
    }

    public static function runJavasriptCode($code, $pos = View::POS_READY) {
        Yii::$app->view->registerJs($code, $pos);
    }

	public static function getAgentInfo($isLowerCase = false) {
		try {
			$userAgent = UserAgent::model();
		} catch(InvalidArgumentException $e) {
			return [];
		}
		
		/* @var \xj\ua\UserAgent $userAgent */
		$uaAttributes =  $userAgent->getAttributes();
		if($isLowerCase) {
			foreach($uaAttributes as &$attribute) {
				$attribute = strtolower($attribute);
			}
		}
		return $uaAttributes;
	}
	
	public static function getCurrentPage($offset, $limit) {
		$page = floor($offset / $limit) + 1;
		return $page;
	}
	
	public static function crutchForPaginate(Query $query = null, $defaultLimit = 20) {
    	$getParams = Yii::$app->request->getQueryParams();
		
		$p = [];
		$names = ['page', 'per-page', 'limit', 'offset'];
		foreach($names as $name) {
			$queryValue = $query->getParam($name);
			if($queryValue) {
				$p[$name] = intval($queryValue);
				unset($getParams[$name]);
				$query->removeParam($name);
			}
		}
		
		$page = 1;
		$offset = 0;
		$limit = $defaultLimit;
		
		if(!empty($p['limit'])) {
			$limit = $p['limit'];
		} elseif(!empty($p['per-page'])) {
			$limit = $p['per-page'];
		}
		
		if(isset($p['page'])) {
			$page = $p['page'];
			if($page < 1) {
				$page = 1;
			}
			$offset = ($page - 1) * $limit;
		}
		
		if(isset($p['offset'])) {
			$offset = $p['offset'];
			$page = self::getCurrentPage($offset, $limit);
		}
		$query->page($page);
		$query->offset($offset);
		$query->limit($limit);
		Yii::$app->request->setQueryParams($getParams);
	}
	
	public static function getQueryFromRequest($queryParams = null) {
		if($queryParams === null) {
			$queryParams = Yii::$app->request->get();
		}
		$getParams = new GetParams();
		return $getParams->getAllParams($queryParams);
	}
	
    public static function ip() {
    	if (self::isConsole()) {
            return self::LOCALHOST_IP;
        }
        $ip = self::getIpFromHeader();
    	if($ip) {
    		return $ip;
	    }
	    $ip = self::getIpFromRequest();
	    if($ip) {
		    return $ip;
	    }
    }
	
	private static function getIpFromHeader() {
		if (self::isConsole()) {
			return self::LOCALHOST_IP;
		}
		$ip = Yii::$app->request->headers->get(self::IP_HEADER_KEY, false);
		return $ip;
	}
 
	public static function getIpFromRequest() {
		if (self::isConsole()) {
			return self::LOCALHOST_IP;
		}
		/* if ($_SERVER['REMOTE_ADDR'] == env('servers.nat.address') && isset($_SERVER['HTTP_CLIENT_IP'])) {
			 $clientIp = $_SERVER['HTTP_CLIENT_IP'];
		 } else {
			 $clientIp = $_SERVER['REMOTE_ADDR'];
		 }*/
		return Yii::$app->request->userIP;
	}
 
	private static function isConsole() {
		// todo: костыль
		return true;
		return APP == CONSOLE;
	}
}
