<?php

class Kesejahteraan_model extends CI_Model
{
    public function insert($data)
    {
        $this->load->library('Exceptions');
        $this->db->trans_begin();
        $data = $data;
        try {
            foreach ($data as $key => $value) {
                $item = [
                    'jeniskesejahteraan' => $value['jeniskesejahteraan'],
                    'nomor' => $value['nomor'],
                    'daritahun' => $value['daritahun'],
                    'sampaitahun' => $value['sampaitahun'],
                    'idcalonsiswa' => $value['idcalonsiswa'],
                ];
                if ($value['idkesejahteraan'] == 0) {
                    $this->db->insert('kesejahteraan', $item);
                    $this->exceptions->checkForError();
                    $item['idkesejahteraan'] = $this->db->insert_id();
                    $data[$key] = $item;
                } else {
                    $this->db->where('idkesejahteraan', $value['idkesejahteraan']);
                    $this->db->update('kesejahteraan', $item);
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
                'jenisbeasiswa' => $value->jenisbeasiswa,
                'penyelenggaraan' => $value->penyelenggaraan,
                'tahunmulai' => $value->tahunmulai,
                'tahunselesai' => $value->tahunselesai,
                'idcalonsiswa' => $value->idcalonsiswa,
            ];
            $this->db->where('idkesejahteraan', $data->idkesejahteraan);
            $this->db->update('kesejahteraan', $item);
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
