<?php

class Beasiswa_model extends CI_Model
{
    public function insert($data, $idcalonsiswa)
    {
        $this->load->library('Exceptions');
        $this->load->library('my_lib');
        $this->db->trans_begin();
        $result = $this->db->query("SELECT * FROM beasiswa WHERE idcalonsiswa='$idcalonsiswa'");
        $databesasiswa = $result->result_array();
        try {
            foreach ($data as $key => $value) {
                $item = [
                    'jenisbeasiswa' => $value['jenisbeasiswa'],
                    'penyelenggaraan' => $value['penyelenggaraan'],
                    'tahunmulai' => $value['tahunmulai'],
                    'tahunselesai' => $value['tahunselesai'],
                    'idcalonsiswa' => $value['idcalonsiswa'],
                ];
                if ((int) $value['idbeasiswa'] == 0) {
                    $this->db->insert('beasiswa', $item);
                    $this->exceptions->checkForError();
                    $item['idbeasiswa'] = $this->db->insert_id();
                    $data[$key] = $item;
                } else {
                    $this->db->where('idbeasiswa', $value['idbeasiswa']);
                    $this->db->update('beasiswa', $item);
                }
            }
            foreach ($databesasiswa as $key => $value) {
                $dataitem = $this->my_lib->FindBeasiswa($data, $value['idbeasiswa']);
                if (is_null($dataitem)) {
                    $this->db->where('idbeasiswa', $value['idbeasiswa']);
                    $this->db->delete('beasiswa');
                }
            }
            $this->db->trans_commit();
            return $data;
        } catch (IMySQLException $th) {
            $this->db->trans_rollback();
            $model = $th->getErrorMessage();
            throw new Exception($model['error']['message']);
            return false;
        }
    }
    public function update($data)
    {
        $this->load->library('Exceptions');
        
        $this->db->trans_begin();
        
        foreach ($databesasiswa as $key => $value) {
            $dataitem = $this->my_lib->FindBeasiswa($data, $value['idbeasiswa']);
            if (!is_null($dataitem)) {
                $item = [
                    'jenisbeasiswa' => $dataitem['jenisbeasiswa'],
                    'penyelenggaraan' => $dataitem['penyelenggaraan'],
                    'tahunmulai' => $dataitem['tahunmulai'],
                    'tahunselesai' => $dataitem['tahunselesai'],
                ];
                $this->db->where('idbeasiswa', $dataitem['idbeasiswa']);
                $this->db->update('beasiswa', $item);
            } else {
                $this->db->where('idbeasiswa', $value['idbeasiswa']);
                $this->db->delete('beasiswa');
            }

        }
        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }
}
