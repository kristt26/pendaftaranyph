<?php defined('BASEPATH') or exit('No direct script access allowed');

use Restserver\Libraries\REST_Controller;

require APPPATH . '/libraries/REST_Controller.php';

class Statusselesai extends \Restserver\Libraries\REST_Controller
{
    public function __construct($config = 'rest')
    {
        parent::__construct($config);
        $this->load->model('Statusselesai_model');
    }

    public function Ambil_get()
    {
        $this->load->library('Authorization_Token');
        $this->load->library('Exceptions');
        $is_valid_token = $this->authorization_token->validateToken();
        if ($is_valid_token['status'] === true) {
            try {
                $Output = $this->Statusselesai_model->get($_GET['idcalonsiswa']);
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
}