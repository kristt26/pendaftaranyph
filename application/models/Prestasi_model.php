<?php

class Prestasi_model extends CI_Model
{
    public function insert($data, $idcalonsiswa)
    {
        $this->load->library('Exceptions');
        $this->load->library('my_lib');
        $this->db->trans_begin();
        $result = $this->db->query("SELECT * FROM prestasi WHERE idcalonsiswa='$idcalonsiswa'");
        $dataprestasi = $result->result_array();
        try {
            foreach ($data as $key => $value) {
                $item = [
                    'penyelenggaraan' => $value['penyelenggaraan'],
                    'jenisprestasi' => $value['jenisprestasi'],
                    'tingkat' => $value['tingkat'],
                    'namaprestasi' => $value['namaprestasi'],
                    'tahun' => $value['tahun'],
                    'idcalonsiswa' => $value['idcalonsiswa']
                ];
                if ((int)$value['idprestasi'] == 0) {
                    $this->db->insert('prestasi', $item);
                    $this->exceptions->checkForError();
                    $item['idprestasi'] = $this->db->insert_id();
                    $data[$key] = $item;
                } else {
                    $this->db->where('idprestasi', $value['idprestasi']);
                    $this->db->update('prestasi', $item);
                }
            }
            foreach ($dataprestasi as $key => $value) {
                $dataitem = $this->my_lib->FindPrestasi($data, $value['idprestasi']);
                if (is_null($dataitem)) {
                    $this->db->where('idprestasi', $value['idprestasi']);
                    $this->db->delete('prestasi');
                }
            }
            $this->db->trans_commit();
            return $data;
        } catch (IMySQLException $th) {
            $this->db->trans_rollback();
            $model = $th->getErrorMessage();
            throw new Exception($model['error']['message']);
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
