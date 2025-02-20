<?php

namespace DissertationCouncils\Services;

use DissertationCouncils\Exceptions\Exception;
use DissertationCouncils\Exceptions\UserNotFoundException;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class TokenService {
    /**
     * @throws \Exception
     */
    public function getPhoneWithCheck($token) {
//                error_reporting(E_ALL);
//        ini_set('display_errors', 1);
        require_once dirname(__FILE__) . '/../../../../vendor/autoload.php';

        $keys = file_get_contents(
            "https://www.googleapis.com/robot/v1/metadata/x509/securetoken@system.gserviceaccount.com"
        );
        $keys = json_decode($keys,true);

        $keysArray = array();
        foreach ($keys as $kid=>$key) {
            $keysArray[$kid] = new Key($key, "RS256");
        }

        try {
            $decoded = JWT::decode($token, $keysArray);

            if(!empty($decoded->phone_number)) {
                return $decoded->phone_number;
            }

            throw new UserNotFoundException();
        } catch (\Exception $exception) {
            throw new Exception("Неизвестная ошибка");
        }

    }
}