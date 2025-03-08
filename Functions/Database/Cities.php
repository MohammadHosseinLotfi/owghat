<?php
class City
{
    private $db;
    private $table = "cities";
    function __construct($db)
    {
        $this->db = $db;
    }

    function getInfoCity($name) {
        $data = $this->db->select($this->table, "*", ["name" => $name]);
        if(sizeof($data) == 0) {
            return false;
        }
        return $data[0];
    }
}
