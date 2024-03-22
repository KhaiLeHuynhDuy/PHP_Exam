<?php
require_once("config/db.class.php");

class User {
    public $id;
    public $username;
    public $password;
    public $fullname;
    public $email;
    public $role;

    public function __construct($username, $password, $fullname, $email, $role) {
        $this->username = $username;
        $this->password = $password;
        $this->fullname = $fullname;
        $this->email = $email;
        $this->role = $role;
    }

    public function save() {
        $db = new Db();
        $sql = "INSERT INTO USER (USERNAME, PASSWORD, FULLNAME, EMAIL, ROLE) VALUES ('$this->username', '$this->password', '$this->fullname', '$this->email', '$this->role')";
        $result = $db->query_execute($sql);
        return $result;
    }

    public static function getByUsername($username) {
        $db = new Db();
        $sql = "SELECT * FROM USER WHERE USERNAME = '$username'";
        $result = $db->select_to_array($sql);
        if (!empty($result)) {
            $user_info = $result[0];
            $user = new User($user_info['USERNAME'], $user_info['PASSWORD'], $user_info['FULLNAME'], $user_info['EMAIL'], $user_info['ROLE']);
            $user->id = $user_info['ID'];
            return $user; // Trả về đối tượng User nếu tìm thấy người dùng
        } else {
            return null; // Trả về null nếu không tìm thấy người dùng
        }
    }
    
}
?>
