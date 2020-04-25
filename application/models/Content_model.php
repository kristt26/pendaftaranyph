<?php

class Content_Model extends CI_Model
{
    public function select($idcontent)
    {
        if ($idcontent) {
            $this->db->query("SELECT * FROM content WHERE idcontent = '$idcontent'");
            $item = $result->result_array();
            $item = $item[0];
            $item['status'] = $item['status'] == 1 ? true : false;
            return $item[0];
        } else {
            $this->db->get("content");
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
            'content' => $data->content,
            'status' => $value->status ? 1 : 0
        ];
        $this->db->insert('content', $item);
        $data->idcontent = $this->db->insert_id();
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
            'content' => $data->content,
            'status' => $value->status ? 1 : 0
        ];
        $this->db->where('idcontent', $data->idcontent);
        $this->db->update('content', $item);
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
        $this->db->where('idcontent', $id);
        $result = $this->db->delete('content');
        return $result;
    }
}
