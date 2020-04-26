<?php

class Persyaratan_model extends CI_Model
{
    public function select($idpersyaratan)
    {
        if ($idpersyaratan) {
            $result = $this->db->query("SELECT * FROM persyaratan WHERE idpersyaratan = '$idpersyaratan'");
            $item = $result->result_array();
            $item = $item[0];
            $item['status'] = $item['status'] == 1 ? true : false;
            return $item;
        } else {
            $result = $this->db->get("persyaratan");
            $item = $result->result_object();
            foreach ($item as $key => $value) {
                $value->status = $value->status == 1 ? true : false;
            }
            return (array) $item;
        }
    }

    public function insert($data)
    {
        $this->db->trans_begin();
        $data = (object) $data;
        $item = [
            'persyaratan' => $data->persyaratan,
            'status' => $data->status ? 1 : 0
        ];
        $this->db->insert('persyaratan', $item);
        $data->idpersyaratan = $this->db->insert_id();
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
        $item = [
            'persyaratan' => $data->persyaratan,
            'status' => $data->status ? 1 : 0
        ];
        $this->db->where('idpersyaratan', $data->idpersyaratan);
        $this->db->update('persyaratan', $item);
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
        $this->db->where('idpersyaratan', $id);
        $result = $this->db->delete('persyaratan');
        return $result;
    }
}
