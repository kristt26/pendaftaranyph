<?php

class Kelulusan_model extends CI_Model
{
    public function select($idkelulusan)
    {
        if($idkelulusan){
            $this->db->where('idkelulusan', $idkelulusan);
            $result = $this->db->get('kelulusan');
            $item = $result->result_array();
            return $item[0];
        }else{
            $result = $this->db->get('kelulusan');
            return $result->result_array();
        }
    }
    public function insert($data)
    {
        $item = [
            'idtahunajaran'=>$data['idtahunajaran'],
            'idsiswa'=> $data['idsiswa'],
            'status'=> $data['status'],
            'Berkas'=> $data['Berkas']
        ];
        $result = $this->db->insert('kelulusan', $item);
        $data['idkelulusan']= $this->db->insert_id();
        return $data;
    }
    public function update($data)
    {
        $item = [
            'idtahunajaran'=>$data['idtahunajaran'],
            'idsiswa'=> $data['idsiswa'],
            'status'=> $data['status'],
            'Berkas'=> $data['Berkas']
        ];
        $this->db->trans_begin();
        $this->db->where('idkelulusan', $data['idkelulusan']);
        $this->db->update('kelulusan', $item);
        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }
    public function delete($id)
    {
        $this->db->trans_start();
        $a = $this->select($id);
        $siswa = $a[0];
        $this->db->where('iduser', $siswa['iduser']);
        $this->db->delete('userinrole');
        $this->db->where('idkelulusan', $id);
        $this->db->delete('kelulusan');
        $this->db->where('iduser', $siswa['iduser']);
        $this->db->delete('user');
        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
        $this->db->where('idkelulusan', $id);
        $result = $this->db->delete('kelulusan');
        return $result;
    }
}
