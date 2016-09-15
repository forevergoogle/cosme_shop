<?php
/**
 * Created by PhpStorm.
 * User: mith
 * Date: 6/16/2016
 * Time: 4:19 PM
 */
   class Upload extends CI_Controller
   {

       public function __construct()
       {
           parent::__construct();
           $this->load->helper(array('form', 'url'));
       }

       public function index()
       {
           //load file upload form
           $this->load->view('admin/upload_file_view');
       }

       public function do_upload()
       {

        //echo nl2br(print_r($_FILES,1));
        $target_dir = "./uploads/";
//        $target_file = $target_dir . basename($_FILES["file"]["name"]);
        $temp = explode(".", $_FILES["file"]["name"]);
        $newfilename = round(microtime(true)) . '.' . end($temp);
         move_uploaded_file($_FILES["file"]["tmp_name"], $target_dir.$newfilename);
        //move_uploaded_file($_FILES["file"]["tmp_name"], $target_file);
         echo json_encode($_FILES["file"]);

       }

       private function set_upload_options()
       {
           //upload an image options
           $config = array();
           $config['upload_path'] = './uploads/';
           $config['allowed_types'] = 'gif|jpg|png';
           $config['max_size'] = '0';
           $config['overwrite'] = FALSE;

           return $config;
       }
   }
