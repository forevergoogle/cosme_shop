<?php
/**
 * Created by PhpStorm.
 * User: mith
 * Date: 6/14/2016
 * Time: 10:36 AM
 */
class Products extends MY_Controller{

    function __construct(){
        parent::__construct();

        $this->load->helper(array('form', 'url'));
        $this->load->model('mcategory');
        $this->load->model('mproduct');
    }

    public function index(){

        $this->data['data'] = 'test';
        $this->render('admin/products_list','admin');
    }

    public function addProduct(){

        //validate form input
        $this->form_validation->set_rules('name', 'Name', 'required');
//        $this->form_validation->set_rules('password', 'Password', 'required');
        $cates = $this->mcategory->listCategories();
        $this->data['categories'] = $cates;
        $this->render('admin/product_add_main','admin');
    }

    public function do_upload()
    {
        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('descr', 'Content', 'required');
        $this->form_validation->set_rules('price', 'Price', 'required');
        if($this->form_validation->run()===TRUE){
            $config = array();
            $config['upload_path'] = './uploads/';
            $config['allowed_types'] = 'gif|jpg|png';

            $this->load->library('upload', $config);
            $files = $_FILES;
            $count = count($_FILES['userfile']['size']);
            $name_array = array();
            for ($i = 0; $i < $count; $i++) {
                $_FILES['userfile']['name'] = $files['userfile']['name'][$i];
                $_FILES['userfile']['type'] = $files['userfile']['type'][$i];
                $_FILES['userfile']['tmp_name'] = $files['userfile']['tmp_name'][$i];
                //               $_FILES['userfile']['error']= $files['userfile']['error'][$i];
                $_FILES['userfile']['size'] = $files['userfile']['size'][$i];

                $this->upload->do_upload();
                $data = $this->upload->data();

                $name_array[] = $data['file_name'];
            }

            $name_image = implode(',', $name_array);

            $name = $this->input->post('name');
            $cateId = $this->input->post('name_cate');
            $content = $this->input->post('descr');
            $price = $this->input->post('price');

            $data = array(
                'name' => $name,
                'cate_id' => $cateId,
                'content' => $content,
                'price' => $price,
                'image_list' => $name_image
            );
            $addpro = $this->mproduct->addProduct($data);
            if($addpro)
//                echo json_encode(array('status'=> 1));die;
                redirect("/admin/products/getListProduct");
        }

    }
    // list product
    public function getListProduct(){

        $products = $this->mproduct->getListProduct();
        $cates = $this->mcategory->listCategories();
        $this->data['products'] = $products;
        $this->data['cates'] = $cates;
        $this->render('admin/products_list','admin');
    }
    // Edit product

    public function editProduct(){

        $idPro = $this->input->get('id');
        $data  = $this->mproduct->getProductById($idPro);
        $cates = $this->mcategory->listCategories();
        $this->data['cates'] = $cates;
//        var_dump($data);die;
        $this->data['dataPro'] = $data;
        $this->render('admin/product_edit', 'admin');
    }

    // Delete image
    public function deleteImage(){


    }

}