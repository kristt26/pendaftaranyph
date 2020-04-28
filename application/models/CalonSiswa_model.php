<?php

class CalonSiswa_Model extends CI_Model
{
    public function select($idcalonsiswa)
    {
        if ($idcalonsiswa) {
            $xd = $this->db->query("
            SELECT
            *
            FROM
            `calonsiswa`
            WHERE calonsiswa.idcalonsiswa='$idcalonsiswa'
            ");
            $result = $xd->result_object();
            $orangtua = [];
            $beasiswa = [];
            $kesejahteraan = [];
            $prestasi = [];
            $detailpersyaratan = [];
            $itembeasiswa = $this->db->query("
            SELECT
            *
            FROM
            `beasiswa`
            WHERE idcalonsiswa='$idcalonsiswa'
            ");
            $beasiswa = $itembeasiswa->result_array();
            $itemorangtua = $this->db->query("SELECT * FROM `orangtua` WHERE idcalonsiswa='$idcalonsiswa'");
            $orangtua = $itemorangtua->result_array();
            $itemkesejahteraan = $this->db->query("SELECT * FROM `kesejahteraan` WHERE idcalonsiswa='$idcalonsiswa'");
            $kesejahteraan = $itemkesejahteraan->result_array();
            $itemprestasi = $this->db->query("SELECT * FROM `prestasi` WHERE idcalonsiswa='$idcalonsiswa'");
            $prestasi = $itemprestasi->result_array();
            $itempersyaratan = $this->db->query("SELECT * FROM `detailpersyaratan` WHERE idcalonsiswa='$idcalonsiswa'");
            $detailpersyaratan = $itempersyaratan->result_array();
            $biodata = [
                'idcalonsiswa' => $result[0]->idcalonsiswa,
                'nis' => $result[0]->nis,
                'nama' => $result[0]->nama,
                'jeniskelamin' => $result[0]->jeniskelamin,
                'kontak' => $result[0]->kontak,
                'alamat' => $result[0]->alamat,
                'tempatlahir' => $result[0]->tempatlahir,
                'tanggallahir' => $result[0]->tanggallahir,
                'asalsekolah' => $result[0]->asalsekolah,
                'iduser' => $result[0]->iduser,
                'idtahunajaran' => $result[0]->idtahunajaran,
                'jurusan' => $result[0]->jurusan,
                'orangtua' => $orangtua,
                'beasiswa' => $beasiswa,
                'kesejahteraan' => $kesejahteraan,
                'detailpersyaratan' => $detailpersyaratan,
                'prestasi' => $prestasi,
            ];
            if ($biodata) {
                return (array) $biodata;
            } else {
                return [];
            }   

        } else {
            $result = $this->db->query("
            SELECT
                *
            FROM
            `calonsiswa`
            ");
            return $result->result_array();
        }
    }
    public function insert($data)
    {
        $this->db->trans_begin();
        $pass = md5($data['password']);
        $user = $data['username'];
        $this->db->query("INSERT INTO user values('','$user', '$pass','true')");
        $iduser = $this->db->insert_id();
        $item = [
            'nis' => $data['nis'],
            'nama' => $data['nama'],
            'jeniskelamin' => $data['jeniskelamin'],
            'kontak' => $data['kontak'],
            'alamat' => $data['alamat'],
            'tempatlahir' => $data['tempatlahir'],
            'tanggallahir' => $data['tanggallahir'],
            'asalsekolah' => $data['asalsekolah'],
            "iduser" => $iduser,
            'idtahunajaran' => $data['idtahunajaran'],
            'jurusan' => $data['jurusan']
        ];
        $this->db->query("INSERT INTO userinrole values('','$iduser', '2')");
        $this->db->insert('calonsiswa', $item);
        $item['idcalonsiswa'] = $this->db->insert_id();
        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return $item;
        }
    }
    public function update($data)
    {
        $item = [
            'nis' => $data['nis'],
            'nama' => $data['nama'],
            'jeniskelamin' => $data['jeniskelamin'],
            'kontak' => $data['kontak'],
            'alamat' => $data['alamat'],
            'tempatlahir' => $data['tempatlahir'],
            'tanggallahir' => $data['tanggallahir'],
            'asalsekolah' => $data['asalsekolah'],
            "iduser" => $data['iduser'],
            'idtahunajaran' => $data['idtahunajaran'],
            'jurusan' => $data['jurusan']
        ];
        $this->db->trans_begin();
        $this->db->where('idcalonsiswa', $data['idcalonsiswa']);
        $this->db->update('calonsiswa', $item);
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
    //     $this->db->where('idsiswa', $id);
    //     $this->db->delete('siswa');
    //     $this->db->where('iduser', $siswa['iduser']);
    //     $this->db->delete('user');
    //     if ($this->db->trans_status() === false) {
    //         $this->db->trans_rollback();
    //         return false;
    //     } else {
    //         $this->db->trans_commit();
    //         return true;
    //     }
    //     $this->db->where('idsiswa', $id);
    //     $result = $this->db->delete('siswa');
    //     return $result;
    // }
}
