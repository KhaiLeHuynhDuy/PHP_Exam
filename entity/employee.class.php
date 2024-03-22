<?php
require_once("config/db.class.php");

class Employee {
    public $ma_nv;
    public $ten_nv;
    public $phai;
    public $noi_sinh;
    public $ma_phong;
    public $luong;

    public function __construct($ma_nv, $ten_nv, $phai, $noi_sinh, $ma_phong, $luong) {
        $this->ma_nv = $ma_nv;
        $this->ten_nv = $ten_nv;
        $this->phai = $phai;
        $this->noi_sinh = $noi_sinh;
        $this->ma_phong = $ma_phong;
        $this->luong = $luong;
    }

    public function save() {
        $db = new Db();
        $sql = "INSERT INTO NHANVIEN (MA_NV, TEN_NV, PHAI, NOI_SINH, MA_PHONG, LUONG) VALUES ('$this->ma_nv', '$this->ten_nv', '$this->phai', '$this->noi_sinh', '$this->ma_phong', '$this->luong')";
        $result = $db->query_execute($sql);
        return $result;
    }

    public static function getAll($startIndex, $limit) {
        $db = new Db();
        $sql = "SELECT * FROM NHANVIEN LIMIT $startIndex, $limit";
        $result = $db->select_to_array($sql);
        
        $employees = array();
        foreach ($result as $row) {
            $employee = new Employee($row['MA_NV'], $row['TEN_NV'], $row['PHAI'], $row['NOI_SINH'], $row['MA_PHONG'], $row['LUONG']);
            $employees[] = $employee;
        }
        return $employees;
    }
    
    public static function countAll() {
        $db = new Db();
        $sql = "SELECT COUNT(*) AS total FROM NHANVIEN";
        $result = $db->select_to_array($sql);
        return $result[0]['total'];
    }
    public static function deleteById($ma_nv) {
        $db = new Db();
        $sql = "DELETE FROM NHANVIEN WHERE MA_NV = '$ma_nv'";
        $result = $db->query_execute($sql);
        return $result;
    }

    public static function update($ma_nv, $ten_nv, $phai, $noi_sinh, $ma_phong, $luong) {
        $db = new Db();
        $sql = "UPDATE NHANVIEN SET TEN_NV = '$ten_nv', PHAI = '$phai', NOI_SINH = '$noi_sinh', MA_PHONG = '$ma_phong', LUONG = '$luong' WHERE MA_NV = '$ma_nv'";
        $result = $db->query_execute($sql);
        return $result;
    }
    
    
}
?>
