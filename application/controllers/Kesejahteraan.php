<?php defined('BASEPATH') or exit('No direct script access allowed');

use Restserver\Libraries\REST_Controller;

require APPPATH . '/libraries/REST_Controller.php';

class Kesejahteraan extends \Restserver\Libraries\REST_Controller
{
    public function __construct($config = 'rest')
    {
        parent::__construct($config);
        $this->load->model('Kesejahteraan_model');
    }

    public function simpan_post()
    {
        $this->load->library('Authorization_Token');
        $this->load->library('Exceptions');
        $is_valid_token = $this->authorization_token->validateToken();
        if ($is_valid_token['status'] === true) {
            try {
                $POST = json_decode($this->security->xss_clean($this->input->raw_input_stream), true);
                $Output = $this->Kesejahteraan_model->insert($POST);
                if ($Output) {
                    $this->response($Output, REST_Controller::HTTP_OK);
                }else{
                    $this->response("Data Tidak Tersimpan", REST_Controller::HTTP_BAD_REQUEST);
                }
            } catch (Exception $error) {
                $this->response($error->getMessage(), REST_Controller::HTTP_BAD_REQUEST);
            }
        }else{
            $this->response("Unauthorized", REST_Controller::HTTP_UNAUTHORIZED);
        }
    }
    public function ubah_put()
    {
        $this->load->library('Authorization_Token');
        $is_valid_token = $this->authorization_token->validateToken();
        if ($is_valid_token['status'] === true) {
            $POST = json_decode($this->security->xss_clean($this->input->raw_input_stream), true);
            $Output = $this->Kesejahteraan_model->update($POST);
            if ($Output) {
                $this->response(true, REST_Controller::HTTP_OK);
            }else{
                $this->response(false, REST_Controller::HTTP_BAD_REQUEST);
            }
        }
    }
}