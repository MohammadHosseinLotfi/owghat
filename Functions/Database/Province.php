<?php
class Province
{
    private $db;
    private $table = "province";
    function __construct($db)
    {
        $this->db = $db;
    }

    function getName($id) {
        $data = $this->db->select($this->table, "*", ["id" => $id]);
        if(sizeof($data) == 0) {
            return false;
        }
        return $data[0];
    }
}
