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
            $nilai = null;

            if (count($result) > 0) {
                $itemnilai = $this->db->query("SELECT * FROM `nilai` WHERE idcalonsiswa='$idcalonsiswa'");
                $nilai = $itemnilai->result_array();
                $nilai = count($nilai) > 0 ? $nilai[0] :(object) array('uas' => 0);
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
                $itempersyaratan = $this->db->query("SELECT
                `detailpersyaratan`.*,
                `persyaratan`.`persyaratan`
            FROM
                `detailpersyaratan`
                LEFT JOIN `persyaratan` ON `persyaratan`.`idpersyaratan` =
                `detailpersyaratan`.`idpersyaratan` WHERE idcalonsiswa='$idcalonsiswa'");
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
                    'status' => $result[0]->status == "1" ? "Lulus" : $result[0]->status == "0" ? "Tidak Lulus" : null,
                    'nisn' => $result[0]->nisn,
                    'nik' => $result[0]->nik,
                    'agama' => $result[0]->agama,
                    'kewarganegaraan' => $result[0]->kewarganegaraan,
                    'statusdalamkeluarga' => $result[0]->statusdalamkeluarga,
                    'anakke' => $result[0]->anakke,
                    'jumlahsaudarakandung' => $result[0]->jumlahsaudarakandung,
                    'beratbadan' => $result[0]->beratbadan,
                    'tinggibadan' => $result[0]->tinggibadan,
                    'golongandarah' => $result[0]->golongandarah,
                    'asalsuku' => $result[0]->asalsuku,
                    'alamatsmp' => $result[0]->alamatsmp,
                    'statussmp' => $result[0]->statussmp,
                    'tahunlulus' => $result[0]->tahunlulus,
                    'email' => $result[0]->email,
                    'statusselesai' => $result[0]->statusselesai == "1" ? true : false,
                    'nomorpendaftaran' => $result[0]->nomorpendaftaran,
                    'orangtua' => $orangtua,
                    'beasiswa' => $beasiswa,
                    'kesejahteraan' => $kesejahteraan,
                    'detailpersyaratan' => $detailpersyaratan,
                    'prestasi' => $prestasi,
                    'nilai' => $nilai
                ];
                return (array) $biodata;
            } else {
                return [];
            }

        } else {
            $result = $this->db->query("
            SELECT
            `calonsiswa`.*
            FROM
            `calonsiswa`
            LEFT JOIN `tahunajaran` ON `tahunajaran`.`idtahunajaran` =
                `calonsiswa`.`idtahunajaran`
            WHERE
            `tahunajaran`.`status` = 1
            ");
            $data = $result->result_array();
            foreach ($data as $key => $value) {
                if ($value['status'] == "1") {
                    $data[$key]['status'] = "Lulus";
                } else if ($value['status'] == "0") {
                    $data[$key]['status'] = "Tidak Lulus";
                } else {
                    $data[$key]['status'] = null;
                }
                $data[$key]['statusselesai'] = $value['status'] == "1" ? true: false;
            }
            return $data;
        }
    }
    public function insert($data)
    {
        $this->load->library('Exceptions');
        $this->load->library('my_lib');
        $this->db->trans_begin();
        $pass = md5($data['password']);
        $user = $data['username'];
        try {
            $this->db->query("INSERT INTO user values('','$user', '$pass','true')");
        $iduser = $this->db->insert_id();
        $tahunajaran = $this->db->query("SELECT * from tahunajaran WHERE status = '1'");
        $tahun = $tahunajaran->result_array();
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
            'jurusan' => $data['jurusan'],
            'nisn' => $data["nisn"],
            'nik' => $data["nik"],
            'agama' => $data["agama"],
            'kewarganegaraan' => $data["kewarganegaraan"],
            'statusdalamkeluarga' => $data["statusdalamkeluarga"],
            'anakke' => $data["anakke"],
            'jumlahsaudarakandung' => $data["jumlahsaudarakandung"],
            'beratbadan' => $data["beratbadan"],
            'tinggibadan' => $data["tinggibadan"],
            'golongandarah' => $data["golongandarah"],
            'asalsuku' => $data["asalsuku"],
            'alamatsmp' => $data["alamatsmp"],
            'statussmp' => $data["statussmp"],
            'tahunlulus' => $data["tahunlulus"],
            'email' => $data["email"],
            'nomorpendaftaran' =>  $tahun[0]['tahunajaran'].$this->my_lib->RandomString()

        ];
        $this->db->query("INSERT INTO userinrole values('','$iduser', '2')");
        $this->db->insert('calonsiswa', $item);
        $this->exceptions->checkForError();
        $item['idcalonsiswa'] = $this->db->insert_id();
        $this->db->trans_commit();
            return $item;

        } catch (IMySQLException $th) {
            $this->db->trans_rollback();
            $model = $th->getErrorMessage();
            throw new Exception($model['error']['message']);
            return false;
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
            'jurusan' => $data['jurusan'],
            'status' => $data['status'] === "Lulus" ? 1 : $data['status'] === "Tidak Lulus" ? 0 : null,
            'nisn' => $data["nisn"],
            'nik' => $data["nik"],
            'agama' => $data["agama"],
            'kewarganegaraan' => $data["kewarganegaraan"],
            'statusdalamkeluarga' => $data["statusdalamkeluarga"],
            'anakke' => $data["anakke"],
            'jumlahsaudarakandung' => $data["jumlahsaudarakandung"],
            'alamat' => $data["alamat"],
            'beratbadan' => $data["beratbadan"],
            'tinggibadan' => $data["tinggibadan"],
            'golongandarah' => $data["golongandarah"],
            'asalsuku' => $data["asalsuku"],
            'asalsekolah' => $data["asalsekolah"],
            'alamatsmp' => $data["alamatsmp"],
            'statussmp' => $data["statussmp"],
            'tahunlulus' => $data["tahunlulus"],
            'email' => $data["email"],
        ];
        $item["status"] = $data['status'] === "Lulus" ? 1 : 0;
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
