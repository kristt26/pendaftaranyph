<?php

class Nilai_model extends CI_Model
{
    public function insert($data)
    {
        $this->load->library('Exceptions');
            $this->db->trans_begin();
            $data = $data;
           try {
            $item = [
                'idcalonsiswa' => $data['idcalonsiswa'],
                'uas' => $data['uas'],
                'bahasaindonesia' => $data['bahasaindonesia'],
                'bahasainggris' => $data['bahasainggris'],
                'matematika' => $data['matematika'],
                'ipa' => $data['ipa']
            ];
            if((int)$data['idnilai']==0){
                $this->db->insert('nilai', $item);
                $this->exceptions->checkForError();
                $item['idnilai'] = $this->db->insert_id();
            }else{
                $this->db->where('idnilai', $data['idnilai']);
                $this->db->update('nilai', $item);
            }
            $this->db->trans_commit();
            return $item;
           } catch (IMySQLException  $th) {
               $this->db->trans_rollback();
               $model = $th->getErrorMessage();
              throw new Exception($model['error']['message']);
              return false;
           }
    }
}
