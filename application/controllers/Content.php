<?php defined('BASEPATH') or exit('No direct script access allowed');

use Restserver\Libraries\REST_Controller;

require APPPATH . '/libraries/REST_Controller.php';

class Content extends \Restserver\Libraries\REST_Controller
{
    public function __construct($config = 'rest')
    {
        parent::__construct($config);
        $this->load->model('Content_model');
    }

    public function Ambil_get()
    {
        $output = $this->Content_model->select(isset($_GET) ? $_GET['idcontent'] : false);
        $this->response($output, REST_Controller::HTTP_OK);

    }

    public function simpan_post()
    {
        $this->load->library('Authorization_Token');
        $this->load->library('Exceptions');
        $is_valid_token = $this->authorization_token->validateToken();
        if ($is_valid_token['status'] === true) {
            try {
                $POST = json_decode($this->security->xss_clean($this->input->raw_input_stream), true);
                $Output = $this->Content_model->insert($POST);
                if ($Output) {
                    $this->response($Output, REST_Controller::HTTP_OK);
                } else {
                    $this->response("Data Tidak Tersimpan", REST_Controller::HTTP_BAD_REQUEST);
                }
            } catch (Exception $error) {
                $this->response($error->getMessage(), REST_Controller::HTTP_BAD_REQUEST);
            }
        } else {
            $this->response("Unauthorized", REST_Controller::HTTP_UNAUTHORIZED);
        }
    }
    public function ubah_put()
    {
        $this->load->library('Authorization_Token');
        $this->load->library('Exceptions');
        $is_valid_token = $this->authorization_token->validateToken();
        if ($is_valid_token['status'] === true) {
            try {
                $POST = json_decode($this->security->xss_clean($this->input->raw_input_stream), true);
                $Output = $this->Content_model->update($POST);
                if ($Output) {
                    $this->response($Output, REST_Controller::HTTP_OK);
                } else {
                    $this->response("Gagal Mengubah Data", REST_Controller::HTTP_BAD_REQUEST);
                }
            } catch (\Throwable $th) {
                //throw $th;
            }

        }
    }
    public function Hapus_delete()
    {
        $this->load->library('Authorization_Token');
        $is_valid_token = $this->authorization_token->validateToken();
        if ($is_valid_token['status'] === true) {
            $Output = $this->Content_model->delete($this->uri->segment(3));
            if ($Output) {
                $this->response("Berhasil Menghapus Data", REST_Controller::HTTP_OK);
            } else {
                $this->response("Gagal Menghapus Data", REST_Controller::HTTP_BAD_REQUEST);
            }
        }
    }
}
