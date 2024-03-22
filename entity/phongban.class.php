<?php
require_once("config/db.class.php");

class PhongBan {
    public $ma_phong;
    public $ten_phong;

    public function __construct($ma_phong, $ten_phong) {
        $this->ma_phong = $ma_phong;
        $this->ten_phong = $ten_phong;
    }

    public function save() {
        $db = new Db();
        $sql = "INSERT INTO PHONGBAN (MA_PHONG, TEN_PHONG) VALUES ('$this->ma_phong', '$this->ten_phong')";
        $result = $db->query_execute($sql);
        return $result;
    }

    public static function getAll() {
        $db = new Db();
        $sql = "SELECT * FROM PHONGBAN";
        $result = $db->select_to_array($sql);
        return $result;
    }
}
?>
