<?php

class OrangTua_model extends CI_Model
{
    public function insert($data)
    {
        $this->load->library('Exceptions');
        $this->db->trans_begin();
        $data = $data;
        try {
            foreach ($data as $key => $value) {
                $item = [
                    'nik' => $value['nik'],
                    'tahunlahir' => $value['tahunlahir'],
                    'nama'=>$value['nama'],
                    'berkebutuhankhusus' => $value['kebutuhankhusus'],
                    'pekerjaan' => $value['pekerjaan'],
                    'pendidikan' => $value['pendidikan'],
                    'penghasilan' => $value['penghasilan'],
                    'jenisorangtua' => $value['jenisorangtua'],
                    'idcalonsiswa' => $value['idcalonsiswa'],
                    'pekerjaan' => $value['pekerjaan']
                ];
                if ($value['idorangtua'] == 0) {
                    $this->db->insert('orangtua', $item);
                    $this->exceptions->checkForError();
                    $item['idorangtua'] = $this->db->insert_id();
                    $data[$key] = $item;
                } else {
                    $this->db->where('idorangtua', $value['idorangtua']);
                    $this->db->update('orangtua', $item);
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
        foreach ($data as $key => $value) {
            $item = [
                'nik' => $value->nik,
                'tahunlahir' => $value->tahunlahir,
                'kebutuhankhusus' => $value->kebutuhankhusus,
                'pekerjaan' => $value->pekerjaan,
                'pendidikan' => $value->pendidikan,
                'penghasilan' => $value->penghasilan,
                'jenisorangtua' => $value->jenisorangtua,
                'idcalonsiswa' => $value->idcalonsiswa,
                'pekerjaan' => $value->pekerjaan
            ];
            $this->db->where('idorangtua', $value->idorangtua);
            $this->db->update('orangtua', $item);
        }
        $this->db->where('idpegawai', $data['idpegawai']);
        $this->db->update('pegawai', $item);
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
