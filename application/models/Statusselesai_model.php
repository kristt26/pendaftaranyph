<?php

class Statusselesai_model extends CI_Model
{
    public function get($idcalonsiswa)
    {
        $result = $this->db->query("UPDATE calonsiswa set statusselesai = '1' WHERE idcalonsiswa = '$idcalonsiswa'");
        return $result;
    }    
}
