<?php defined('BASEPATH') or exit('No direct script access allowed');

use Restserver\Libraries\REST_Controller;

require APPPATH . '/libraries/REST_Controller.php';

class DetailPersyaratan extends \Restserver\Libraries\REST_Controller
{
    public function __construct($config = 'rest')
    {
        parent::__construct($config);
        $this->load->model('DetailPersyaratan_model');
    }

    public function Ambil_get()
    {
        $output = $this->DetailPersyaratan_model->select();
        if ($output) {
            $this->response($output, REST_Controller::HTTP_OK);
        }

    }
    public function simpan_post()
    {
        $this->load->library('Authorization_Token');
        $is_valid_token = $this->authorization_token->validateToken();
        if ($is_valid_token['status'] === true) {
            $this->load->library('my_lib');
            $POST = json_decode($this->security->xss_clean($this->input->raw_input_stream), true);
            if ((int) $POST['iddetailpersyaratan'] != 0) {
                if (isset($POST['file'])) {
                    $itempersyaratan = $this->DetailPersyaratan_model->select($POST['iddetailpersyaratan']);
                    $dirFile = './client/berkas/' . $itempersyaratan['berkas'];
                    unlink($dirFile);
                    $encoded_string = !empty($POST['file']) ? $POST['file'] : 'V2ViZWFzeXN0ZXAgOik=';
                    $item = $this->my_lib->upload_file($encoded_string);
                    $item['extension'] = $this->my_lib->mime2ext($item['type']);
                    $a = $item['extension'];
                    $file = uniqid() . '.' . $a;
                    $target_dir = './client/berkas/';
                    $file_dir = $target_dir . $file;
                    file_put_contents($file_dir, $item['file']);
                    $POST['berkas'] = $file;
                    $Output = $this->DetailPersyaratan_model->update($POST);
                    if ($Output) {
                        $this->response($POST, REST_Controller::HTTP_OK);
                    } else {
                        $this->response(false, REST_Controller::HTTP_BAD_REQUEST);
                    }
                } else {
                    $Output = $this->DetailPersyaratan_model->update($POST);
                    if ($Output) {
                        $this->response($POST, REST_Controller::HTTP_OK);
                    } else {
                        $this->response(false, REST_Controller::HTTP_BAD_REQUEST);
                    }
                }
                // $Output = $this->DetailPersyaratan_model->update($POST);
                // if ($Output) {
                //     $this->response($Output, REST_Controller::HTTP_OK);
                // } else {
                //     $this->response(false, REST_Controller::HTTP_BAD_REQUEST);
                // }
            } else {
                $encoded_string = !empty($POST['file']) ? $POST['file'] : 'V2ViZWFzeXN0ZXAgOik=';
                $item = $this->my_lib->upload_file($encoded_string);
                $item['extension'] = $this->my_lib->mime2ext($item['type']);
                $a = $item['extension'];
                $file = uniqid() . '.' . $a;
                $target_dir = './client/berkas/';
                $file_dir = $target_dir . $file;
                file_put_contents($file_dir, $item['file']);
                $POST['berkas'] = $file;
                $Output = $this->DetailPersyaratan_model->insert($POST);
                if ($Output) {
                    $this->response($Output, REST_Controller::HTTP_OK);
                } else {
                    $this->response(false, REST_Controller::HTTP_BAD_REQUEST);
                }
            }
        } else {
            $this->response($is_valid_token, REST_Controller::HTTP_UNAUTHORIZED);
        }
    }
    public function ubah_put()
    {
        $this->load->library('Authorization_Token');
        $is_valid_token = $this->authorization_token->validateToken();
        if ($is_valid_token['status'] === true) {
            $POST = json_decode($this->security->xss_clean($this->input->raw_input_stream), true);
            $datakelulusan = $this->DetailPersyaratan_model->select($POST['idkelulusan']);
            $Output = $this->DetailPersyaratan_model->update($POST);
            if ($Output) {
                $this->response(true, REST_Controller::HTTP_OK);
            } else {
                $this->response(false, REST_Controller::HTTP_BAD_REQUEST);
            }
        }
    }
    public function Hapus_delete()
    {
        $this->load->library('Authorization_Token');
        $is_valid_token = $this->authorization_token->validateToken();
        if ($is_valid_token['status'] === true) {
            $Output = $this->DetailPersyaratan_model->delete($this->uri->segment(3));
            if ($Output) {
                $message = [
                    'status' => true,
                ];
                $this->response($message, REST_Controller::HTTP_OK);
            } else {
                $this->response($message, REST_Controller::HTTP_BAD_REQUEST);
            }
        }
    }
}
