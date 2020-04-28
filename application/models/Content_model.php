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
            $result=$this->db->get("content");
            $item = $result->result_object();
            foreach ($item as $key => $value) {
                $value->status = $value->status == 1 ? true : false;
            }
            return (array) $item;
        }
    }

    public function insert($data)
    {
        $this->load->library('Exceptions');
        $this->db->trans_begin();
        $data = $data;
        try {
            $item = [
                'content' => $data['content'],
                'publish' => $data['publish'] ? 1 : 0,
                'created' => $data['created'],
                'title' => $data['title'],
                'type' => $data['type'],
            ];
            $this->db->insert('content', $item);
            $this->exceptions->checkForError();
            $data['idcontent'] = $this->db->insert_id();
            return $data;
            $this->db->trans_commit();
        } catch (IMySQLException $th) {
            $model = $th->getErrorMessage();
            throw new Exception($model['error']['message']);
        }
    }
    public function update($data)
    {
        $this->load->library('Exceptions');
        $this->db->trans_begin();
        $data = (object) $data;
        try {
            $item = [
                'content' => $data['content'],
                'publish' => $data['publish'] ? 1 : 0,
                'created' => $data['created'],
                'title' => $data['title'],
                'type' => $data['type'],
            ];
            $this->db->where('idcontent', $data['idcontent']);
            $this->db->update('content', $item);
            return $data;
        } catch (\Throwable $th) {
            $this->db->trans_rollback();
            $model = $th->getErrorMessage();
            throw new Exception($model['error']['message']);
            return false;
        }
    }
    public function delete($id)
    {
        $this->db->where('idcontent', $id);
        $result = $this->db->delete('content');
        return $result;
    }
}
