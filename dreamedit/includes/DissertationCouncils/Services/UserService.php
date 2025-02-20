<?php

namespace DissertationCouncils\Services;

use DissertationCouncils\DissertationCouncils;
use DissertationCouncils\Exceptions\UserAlreadyExistException;
use DissertationCouncils\Models\User;

/**
 * Class UserService
 * @package DissertationCouncils\Services
 */
class UserService {

    /**
     * @var string
     */
    private $salt = "F$@f4g54g54r5g";
    /**
     * @var string
     */
    private $key = "FHHA)*geF*EQEsfeqfg";
    /**
     * @var DissertationCouncils
     */
    private $dissertationCouncils;
    /**
     * UserService constructor.
     * @param DissertationCouncils $dissertationCouncils
     */
    public function __construct(DissertationCouncils $dissertationCouncils)
    {
        $this->dissertationCouncils = $dissertationCouncils;
    }

    /**
     * @param string $password
     * @return string
     */
    private function hashPassword($password) {
        return hash_hmac('ripemd160', $this->salt . $password, $this->key);
    }

    /**
     * @param mixed[] $row
     * @return User
     */
    public function mapToUser($row) {
        $user = new User(
            $row['id'],
            $row['firstname'],
            $row['lastname'],
            $row['thirdname'],
            $row['email'],
            $row['password'],
            $this->dissertationCouncils->getStatusService()->getStatusBy($row['status']),
            $row['phone']
        );
        return $user;
    }

    /**
     * @param User $user
     * @return mixed[]
     */
    public function mapToArray($user) {
        $row = array(
            "id" => $user->getId(),
            "firstname" => $user->getFirstName(),
            "lastname" => $user->getLastName(),
            "thirdname" => $user->getThirdName(),
            "email" => $user->getEmail(),
            "password" => $user->getPassword(),
            "status" => $user->getStatus()->getId(),
            "phone" => $user->getPhone()
        );
        return $row;
    }

    /**
     * @param array $data
     * @return mixed[]
     */
    public function mapArrayToDb($data) {
        $data['password'] = $this->hashPassword($data['password']);
        if($data['admin']==1) {
            $data['status'] = 4;
        } else {
            $data['status'] = 2;
        }

        return $data;
    }

    /**
     * @param int $id
     * @return User
     */
    public function getUserById($id) {
        global $DB;

        $userArr = $DB->selectRow("SELECT * FROM dissertation_councils_users WHERE id=?d",$id);

        if(!empty($userArr)) {
            $user = $this->mapToUser($userArr);
            return $user;
        }
        return null;
    }

    /**
     * @param string $email
     * @return User
     */
    public function getUserByEmail($email) {
        global $DB;

        $userArr = $DB->selectRow("SELECT * FROM dissertation_councils_users WHERE email=?",$email);
        if(!empty($userArr)) {
            $user = $this->mapToUser($userArr);
            return $user;
        }
        return null;
    }

    /**
     * @param string $phone
     * @return User
     */
    public function getUserByPhone($phone) {
        global $DB;

        $userArr = $DB->selectRow("SELECT * FROM dissertation_councils_users WHERE phone=?",$phone);
        if(!empty($userArr)) {
            $user = $this->mapToUser($userArr);
            return $user;
        }
        return null;
    }

    /**
     * @param string $email
     * @param string $password
     * @param bool $isHashed
     * @return User
     */
    public function getUserByEmailAndPassword($email,$password, $isHashed = true) {
        global $DB;

        if(!$isHashed) {
            $password = $this->hashPassword($password);
        }

        $userArr = $DB->selectRow("SELECT * FROM dissertation_councils_users WHERE email=? AND password=?",$email,$password);
        if(!empty($userArr)) {
            $user = $this->mapToUser($userArr);
            return $user;
        }
        return null;
    }

    /**
     * @return User
     */
    public function getUserAdmin() {
        global $DB;
        return new User(
            0,
            "Администратор",
            "",
            "",
            "",
            "",
            $this->dissertationCouncils->getStatusService()->getStatusBy(1),
            ""
            );
    }

    /**
     * @return User[]
     */
    public function getAllUsers($sortField="lastname",$sortType="ASC") {
        global $DB;

        $sortField = str_replace(" ","",$sortField);
        if($sortType!="ASC" && $sortType!="DESC") {
            return null;
        }

        $userArr = $DB->select("SELECT * FROM dissertation_councils_users ORDER BY ".$sortField." ".$sortType);

        $users = array();
        foreach ($userArr as $item) {
            $users[] = $this->mapToUser($item);
        }
        return $users;
    }

    /**
     * @param mixed $data
     */
    public function sendPassword($email,$password,$firstName,$thirdName) {

        $nn = "<br>";
        $name = $firstName;
        if(!empty($thirdName)) {
            $name .= " ".$thirdName;
        }
        $data = "Здравствуйте!" . $nn.$nn;
        $data .= "<b>Данные для авторизации в системе голосования диссертационных советов ИМЭМО РАН</b>:" . $nn;

        $data .= $nn."<a href=\"https://imemo.ru/index.php?page_id={$_REQUEST['page_id']}\">Личный кабинет участника диссертационных советов ИМЭМО РАН</a>" . $nn;

        $data .= $nn."<b>Логин:</b> {$email}";
        $data .= $nn."<b>Пароль:</b> {$password}" . $nn.$nn;

        $data .= "С уважением," . $nn;
        $data .= "ИМЭМО РАН" . $nn;

        \MailSend::send_mime_mail("Диссертационные советы ИМЭМО РАН", "noreply@imemo.ru", "", $email, "cp1251", "utf-8", "Личный кабинет участника диссертационных советов ИМЭМО РАН", $data);
    }

    /**
     * @param mixed $data
     * @return bool
     * @throws UserAlreadyExistException
     */
    public function addUser($data) {
        global $DB;

        $existEmailUser = $this->getUserByEmail($data['email']);
        if(!empty($data['phone'])) {
            $existPhoneUser = $this->getUserByPhone($data['phone']);
        } else {
            $data['phone'] = NULL;
        }

        if(!empty($existEmailUser)) {
            throw new UserAlreadyExistException("Пользователь с этим e-mail уже зарегистрирован");
        }
        if(!empty($existPhoneUser)) {
            throw new UserAlreadyExistException("Пользователь с этим номером телефона уже зарегистрирован");
        }

        $data['password'] = \Dreamedit::generatePassword();

        $passwordUnHashed = $data['password'];
        $data = $this->mapArrayToDb($data);
        $DB->query(
            "INSERT INTO dissertation_councils_users(`firstname`,`lastname`,`thirdname`,`email`,`password`,`status`,`phone`) 
                    VALUES(?,?,?,?,?,?,?)",
            $data['firstname'],
            $data['lastname'],
            $data['thirdname'],
            $data['email'],
            $data['password'],
            $data['status'],
            $data['phone']
        );
        $this->sendPassword($data['email'],$passwordUnHashed,$data['firstname'],$data['thirdname']);

        return true;
    }

    /**
     * @param mixed $data
     * @return bool
     */
    public function updateUserWithId($data, $id) {
        global $DB;

        //$passwordUnHashed = $data['password'];

        $existEmailUser = $this->getUserByEmail($data['email']);
        if(!empty($data['phone'])) {
            $existPhoneUser = $this->getUserByPhone($data['phone']);
        } else {
            $data['phone'] = NULL;
        }

        if(!empty($existEmailUser) && $existEmailUser->getId()!=$id) {
            throw new UserAlreadyExistException("Пользователь с этим e-mail уже зарегистрирован");
        }
        if(!empty($existPhoneUser)) {
            throw new UserAlreadyExistException("Пользователь с этим номером телефона уже зарегистрирован");
        }

        $data = $this->mapArrayToDb($data);

        $DB->query(
            "UPDATE dissertation_councils_users 
              SET `firstname`=?,`lastname`=?,`thirdname`=?,`email`=?,`status`=?, `phone`=?
              WHERE id=?d",
            $data['firstname'],
            $data['lastname'],
            $data['thirdname'],
            $data['email'],
            $data['status'],
            $data['phone'],
            $id
        );
        //$this->sendPassword($data['email'],$passwordUnHashed,$data['firstname'],$data['thirdname']);

        return true;
    }

    /**
     * @param int $id
     */
    public function deleteUserById($id) {
        global $DB;

        $user = $this->getUserById($id);
        if(!empty($user)) {
            if (!$user->getStatus()->isAdmin() || $user->getStatus()->isCanVote()) {
                $DB->query("DELETE FROM dissertation_councils_users WHERE id=?d", $id);
            }
        }
    }

    /**
     * @param int $id
     */
    public function changeUserStatusByIdWithId($userId, $statusId) {
        global $DB;

        $user = $this->getUserById($userId);
        $status = $this->dissertationCouncils->getStatusService()->getStatusBy($statusId);
        if(!empty($user) && !empty($status)) {
            if (!$user->getStatus()->isAdmin() || $user->getStatus()->isCanVote()) {
                $DB->query("UPDATE dissertation_councils_users SET status=?d WHERE id=?d", $statusId, $userId);
            }
        }
    }


    /**
     * @return string
     */
    public function registerRequest($email,$password,$firstname,$lastname,$thirdname) {
        global $DB;

        $request_exist = $DB->select('SELECT id, code FROM dissertation_councils_register_request WHERE email = ?', $email);

        if(!empty($request_exist)) {
            $DB->query("DELETE FROM dissertation_councils_register_request WHERE id=?",$request_exist[0]['id']);
        }

        $password = hash_hmac('ripemd160',$this->salt.$password, $this->key);

        if(empty($firstname)) $firstname = '';
        if(empty($lastname)) $lastname = '';
        if(empty($thirdname)) $thirdname = '';

        $code = '';
        $code = str_replace("@", "",str_replace(".","",$email))."_".\UUID::v4();
        $code = $DB->cleanuserinput(mb_strtolower($code));
        //error_reporting(E_ALL);
        $DB->query('INSERT INTO dissertation_councils_register_request(password, firstname,lastname,thirdname,email,code) VALUES(?,?,?,?,?,?)',$password,$firstname,$lastname,$thirdname,$email,$code);
        return $code;
    }

    /**
     * @return string
     */
    public function getResetCode($email) {
        global $DB;

        $user = $this->getUserByEmail($email);

        if(!empty($user)) {
            $DB->query("DELETE FROM dissertation_councils_password_reset_request WHERE email=?",$email);
            $prefix = preg_replace("/[^a-z0-9]/i","",$email);
            $code = $prefix."_".\UUID::v4();
            $code = $DB->cleanuserinput(mb_strtolower($code));
            $DB->query('INSERT INTO dissertation_councils_password_reset_request(email,code) VALUES(?,?)',$email,$code);
            return $code;
        }
        return "";
    }

    /**
     * @return bool
     */
    public function checkResetCode($email, $code) {
        global $DB;

        $resetCodeArr = $DB->selectRow("SELECT * FROM dissertation_councils_password_reset_request WHERE email=? AND code=?",$email,$code);
        if(empty($resetCodeArr)) {
            return false;
        }
        return true;
    }

    /**
     * @return string
     */
    public function updatePassword($email, $code, $password) {
        global $DB;

        if(!empty($code)) {
            $code = $DB->cleanuserinput(mb_strtolower($code));
            $exist = $DB->select('SELECT * FROM dissertation_councils_password_reset_request WHERE code = ? AND email = ?', $code,$email);
            if(!empty($exist)) {
                $password = hash_hmac('ripemd160',$this->salt.$password, $this->key);
                $DB->query('UPDATE dissertation_councils_users SET password=? WHERE email=?',$password,$email);
                $DB->query('DELETE FROM dissertation_councils_password_reset_request WHERE code = ? AND email = ?', $code, $email);
                return "1";
            } else {
                return 'Запрос не найден';
            }
        }
        return "Запрос не найден";
    }

    /**
     * @return string
     */
    public function createUserFromRequest($code) {
        global $DB;

        if(!empty($code)) {
            $code = $DB->cleanuserinput(mb_strtolower($code));
            $exist = $DB->select('SELECT * FROM dissertation_councils_register_request WHERE code = ?', $code);
            if(!empty($exist)) {
                $DB->query('DELETE FROM dissertation_councils_register_request WHERE code = ?', $code);
                $exist_user = $DB->select('SELECT * FROM dissertation_councils_users WHERE email = ?', $exist[0]['email']);
                if(!empty($exist_user)) {
                    return "Вы уже зарегистрированы";
                } else {
                    $DB->query('INSERT INTO dissertation_councils_users(password, firstname, lastname,thirdname,email,status) VALUES(?,?,?,?,?,?)',$exist[0]['password'],$exist[0]['firstname'],$exist[0]['lastname'],$exist[0]['thirdname'],$exist[0]['email'],5);
                    return "Вы успешно зарегистрировались.";
                }
            } else {
                return 'Запрос не найден';
            }
        }
        return "Запрос не найден";
    }

}