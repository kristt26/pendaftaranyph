<?php

class CalonSiswa_Model extends CI_Model
{
    public function select($idcalonsiswa)
    {
        if ($idcalonsiswa) {
            $xd = $this->db->query("
            SELECT
            `calonsiswa`.*,
            `detailpersyaratan`.`iddetailpersyaratan`,
            `detailpersyaratan`.`idpersyaratan`,
            `detailpersyaratan`.`berkas`,
            `prestasi`.`idprestasi`,
            `prestasi`.`penyelenggaraan`,
            `prestasi`.`jenisprestasi`,
            `prestasi`.`tingkat`,
            `prestasi`.`namaprestasi`,
            `prestasi`.`tahun`,
            `beasiswa`.`idbeasiswa`,
            `beasiswa`.`jenisbeasiswa`,
            `beasiswa`.`penyelenggaraan` AS `penyelenggaraan1`,
            `beasiswa`.`tahunmulai`,
            `beasiswa`.`tahunselesai`,
            `kesejahteraan`.`idkesejahteraan`,
            `kesejahteraan`.`jeniskesejahteraan`,
            `kesejahteraan`.`nomor`,
            `kesejahteraan`.`daritahun`,
            `kesejahteraan`.`sampaitahun`,
            `orangtua`.`idorangtua`,
            `orangtua`.`nik`,
            `orangtua`.`tahunlahir`,
            `orangtua`.`berkebutuhankhusus`,
            `orangtua`.`pekerjaan`,
            `orangtua`.`pendidikan`,
            `orangtua`.`penghasilan`,
            `orangtua`.`jenisorangtua`
            FROM
            `calonsiswa`
            LEFT JOIN `detailpersyaratan` ON `detailpersyaratan`.`idcalonsiswa` =
                `calonsiswa`.`idcalonsiswa`
            LEFT JOIN `beasiswa` ON `beasiswa`.`idcalonsiswa` =
                `calonsiswa`.`idcalonsiswa`
            LEFT JOIN `kesejahteraan` ON `kesejahteraan`.`idcalonsiswa` =
                `calonsiswa`.`idcalonsiswa`
            LEFT JOIN `orangtua` ON `orangtua`.`idcalonsiswa` =
                `calonsiswa`.`idcalonsiswa`
            LEFT JOIN `prestasi` ON `prestasi`.`idcalonsiswa` =
                `calonsiswa`.`idcalonsiswa`
            WHERE calonsiswa.idcalonsiswa='$idcalonsiswa'
            ");
            $result = $xd->result_object();
            $orangtua = [];
            $beasiswa = [];
            $kesejahteraan = [];
            $prestasi = [];
            $detailpersyaratan = [];
            foreach ($result as $key => $value) {
                if (!is_null($value->idbeasiswa)) {
                    $item = [
                        'idbeasiswa' => $value->idbeasiswa,
                        'jenisbeasiswa' => $value->jenisbeasiswa,
                        'penyelenggaraan' => $value->penyelenggaraan,
                        'tahunmulai' => $value->tahunmulai,
                        'tahunselesai' => $value->tahunselesai,
                        'idcalonsiswa' => $value->idcalonsiswa
                    ];
                    array_push($beasiswa, $item);
                }
                if (!is_null($value->idorangtua)) {
                    $item = [
                        'idorangtua' => $value->idorangtua,
                        'nik' => $value->nik,
                        'tahunlahir' => $value->tahunlahir,
                        'kebutuhankhusus' => $value->kebutuhankhusus,
                        'pekerjaan' => $value->pekerjaan,
                        'pendidikan' => $value->pendidikan,
                        'penghasilan' => $value->penghasilan,
                        'jenisorangtua' => $value->jenisorangtua,
                        'idcalonsiswa' => $value->idcalonsiswa
                    ];
                    array_push($orangtua, $item);
                }
                if (!is_null($value->idkesejahteraan)) {
                    $item = [
                        'idkesejahteraan' => $value->idkesejahteraan,
                        'jeniskesejahteraan' => $value->jeniskesejahteraan,
                        'nomor' => $value->nomor,
                        'daritahun' => $value->daritahun,
                        'sampaitahun' => $value->sampaitahun,
                        'idcalonsiswa' => $value->idcalonsiswa
                    ];
                    array_push($kesejahteraan, $item);
                }
                if (!is_null($value->idprestasi)) {
                    $item = [
                        'idprestasi' => $value->idprestasi,
                        'penyelenggaraan' => $value->penyelenggaraan,
                        'jenisprestasi' => $value->jenisprestasi,
                        'tingkat' => $value->tingkat,
                        'namaprestasi' => $value->namaprestasi,
                        'tahun' => $value->tahun,
                        'idcalonsiswa' => $value->idcalonsiswa
                    ];
                    array_push($prestasi, $item);
                }
                if (!is_null($value->iddetailpersyaratan)) {
                    $item = [
                        'iddetailpersyaratan' => $value->iddetailpersyaratan,
                        'idcalonsiswa' => $value->idcalonsiswa,
                        'idpersyaratan' => $value->idpersyaratan,
                        'berkas' => $value->berkas
                    ];
                    array_push($detailpersyaratan, $item);
                }
            }
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
