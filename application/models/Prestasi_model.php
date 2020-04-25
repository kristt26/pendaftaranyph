<?php

class Beasiswa_model extends CI_Model
{
    public function insert($data)
    {
        $this->db->trans_begin();
        $data = (object) $data;
        foreach ($data as $key => $value) {
            $item = [
                'penyelenggaraan' => $value->penyelenggaraan,
                'jenisprestasi' => $value->jenisprestasi,
                'tingkat' => $value->tingkat,
                'namaprestasi' => $value->namaprestasi,
                'tahun' => $value->tahun,
                'idcalonsiswa' => $value->idcalonsiswa
            ];
            $this->db->insert('prestasi', $item);
            $item->idprestasi = $this->db->insert_id();
        }
        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return $data;
        }
    }
    public function update($data)
    {
        $this->db->trans_begin();
        $data = (object) $data;
        foreach ($data as $key => $value) {
            $item = [
                'penyelenggaraan' => $value->penyelenggaraan,
                'jenisprestasi' => $value->jenisprestasi,
                'tingkat' => $value->tingkat,
                'namaprestasi' => $value->namaprestasi,
                'tahun' => $value->tahun,
                'idcalonsiswa' => $value->idcalonsiswa
            ];
            $this->db->where('idprestasi', $data['idprestasi']);
            $this->db->update('prestasi', $item);
        }
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
    //     $this->db->where('idpegawai', $id);
    //     $this->db->delete('pegawai');
    //     $this->db->where('iduser', $siswa['iduser']);
    //     $this->db->delete('user');
    //     if ($this->db->trans_status() === false) {
    //         $this->db->trans_rollback();
    //         return false;
    //     } else {
    //         $this->db->trans_commit();
    //         return true;
    //     }
    //     $this->db->where('idpegawai', $id);
    //     $result = $this->db->delete('pegawai');
    //     return $result;
    // }
}
