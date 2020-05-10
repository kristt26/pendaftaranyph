<?php

class DetailPersyaratan_Model extends CI_Model
{
    public function select($iddetailpersyaratan)
    {
        if($iddetailpersyaratan){
            $this->db->where('iddetailpersyaratan', $iddetailpersyaratan);
            $result = $this->db->get('detailpersyaratan');
            $item = $result->result_array();
            return $item[0];
        }else{
            $result = $this->db->get('detailpersyaratan');
            return $result->result_array();
        }
    }
    public function insert($data)
    {
        $item = [
            'idcalonsiswa'=> $data['idcalonsiswa'],
            'idpersyaratan'=> $data['idpersyaratan'],
            'berkas'=> $data['berkas']
        ];
        $result = $this->db->insert('detailpersyaratan', $item);
        $data['iddetailpersyaratan']= $this->db->insert_id();
        return $data;
    }
    public function update($data)
    {
        $item = [
            'idcalonsiswa'=> $data['idcalonsiswa'],
            'idpersyaratan'=> $data['idpersyaratan'],
            'berkas'=> $data['berkas']
        ];
        $this->db->trans_begin();
        $this->db->where('iddetailpersyaratan', $data['iddetailpersyaratan']);
        $this->db->update('detailpersyaratan', $item);
        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }
    // public function delete($id)
    // {
    //     $this->db->trans_start();
    //     $a = $this->select($id);
    //     $siswa = $a[0];
    //     $this->db->where('iduser', $siswa['iduser']);
    //     $this->db->delete('userinrole');
    //     $this->db->where('idkelulusan', $id);
    //     $this->db->delete('kelulusan');
    //     $this->db->where('iduser', $siswa['iduser']);
    //     $this->db->delete('user');
    //     if ($this->db->trans_status() === false) {
    //         $this->db->trans_rollback();
    //         return false;
    //     } else {
    //         $this->db->trans_commit();
    //         return true;
    //     }
    //     $this->db->where('idkelulusan', $id);
    //     $result = $this->db->delete('kelulusan');
    //     return $result;
    // }
}
