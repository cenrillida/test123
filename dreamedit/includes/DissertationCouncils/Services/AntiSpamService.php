<?php

namespace DissertationCouncils\Services;

use DissertationCouncils\DissertationCouncils;
use DissertationCouncils\Exceptions\TryLoginException;

/**
 * Class AntiSpamService
 * @package DissertationCouncils\Services
 */
class AntiSpamService {

    /** @var DissertationCouncils */
    private $dissertationCouncils;

    /**
     * AntiSpamService constructor.
     * @param DissertationCouncils $dissertationCouncils
     */
    public function __construct(DissertationCouncils $dissertationCouncils)
    {
        $this->dissertationCouncils = $dissertationCouncils;
    }

    /**
     * @param string $account
     * @throws TryLoginException
     */
    public function tryLoginRecord($account) {
        global $DB;
        $currentTime = time();
        $currentRecord = $DB->selectRow("SELECT * FROM dissertation_councils_login_log WHERE account=? AND (`date`+60)>?d",$account,$currentTime);

        if(!empty($currentRecord)) {
            if($currentRecord['try_count']>=5) {
                $resetTime = $currentRecord['date']+60-$currentTime;
                $secondsText = \Dreamedit::RusEnding($resetTime,'секунда','секунды', 'секунд');
                throw new TryLoginException("Превышено число попыток. Попробуйте снова через {$resetTime} {$secondsText}");
            } else {
                $DB->query("UPDATE dissertation_councils_login_log SET try_count=try_count+1 WHERE account=?",$account);
                return;
            }
        } else {
            $DB->query("DELETE FROM dissertation_councils_login_log WHERE account=?",$account);
            $DB->query("INSERT INTO dissertation_councils_login_log(`account`,`date`,`try_count`) VALUES (?,?d,1)",$account,$currentTime);
            return;
        }
    }

}