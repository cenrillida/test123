<?php

namespace Contest\Services;

use Contest\Contest;
use Contest\Exceptions\TryLoginException;

/**
 * Class AntiSpamService
 * @package Contest\Services
 */
class AntiSpamService {

    /** @var Contest */
    private $contest;

    /**
     * AntiSpamService constructor.
     * @param Contest $contest
     */
    public function __construct(Contest $contest)
    {
        $this->contest = $contest;
    }


    /**
     * @param string $email
     * @throws TryLoginException
     */
    public function tryLoginRecord($email) {
        global $DB;
        $currentTime = time();
        $currentRecord = $DB->selectRow("SELECT * FROM contest_login_log WHERE email=? AND (`date`+60)>?d",$email,$currentTime);

        if(!empty($currentRecord)) {
            if($currentRecord['try_count']>=5) {
                $resetTime = $currentRecord['date']+60-$currentTime;
                $secondsText = \Dreamedit::RusEnding($resetTime,'секунда','секунды', 'секунд');
                throw new TryLoginException("Превышено число попыток. Попробуйте снова через {$resetTime} {$secondsText}");
            } else {
                $DB->query("UPDATE contest_login_log SET try_count=try_count+1 WHERE email=?",$email);
                return;
            }
        } else {
            $DB->query("DELETE FROM contest_login_log WHERE email=?",$email);
            $DB->query("INSERT INTO contest_login_log(`email`,`date`,`try_count`) VALUES (?,?d,1)",$email,$currentTime);
            return;
        }
    }

}