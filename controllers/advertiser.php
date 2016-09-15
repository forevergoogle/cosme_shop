<?php
/**
 * Created by PhpStorm.
 * User: mith
 * Date: 9/24/2015
 * Time: 10:31 AM
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Class Campaign
 */
class Advertiser extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->library('ion_auth');
        $this->controllerName = $this->router->fetch_class();
        $this->methodName = $this->router->fetch_method();
        $this->load->Model("advertise_model");
        $this->load->Model("brand_model");
        $this->load->Model("product_model");
        $this->load->Model("sector_model");
        $this->load->library('pagination');
        $this->load->library('mypaginator');

    }

    /**
     * @Decorated
     */
    public function home(){
        $data = array();

        $this->load->view("advertiser/home", $data);
    }

    public function ajaxAddAdvertiser(){

        $nameAdv = $this->input->post('name');
        $infoAdv = $this->input->post('content');
        $data = array(
            'name' => $nameAdv,
            'contact_info' => $infoAdv
        );
        $addAdv = $this->advertise_model->addAdvertise($data);

        if($addAdv)
            echo 1;die;
    }

    public function ajaxListBrand(){

        if($this->uri->segment(3)){
            $page = $this->uri->segment(3);
        }else{
            $page = 1;
        }
        $pagingConfigBrand   = $this->mypaginator->initPagination("/advertiser/metadata/ajaxListBrand",$this->brand_model->record_count(),"/index.php/advertiser/ajaxListBrand/1");
        $data["pagination_helper"]   = $this->pagination;
        $data["listBrand"] = $this->brand_model->get_by_range($page,$pagingConfigBrand['per_page']);
        if($this->input->post("isAjax")){
            $this->load->view("meta/list_brand",$data);
        }else{
            $this->load->view("meta/brand",$data);
        }
//        $this->load->view("meta/brand", $data);
    }
    public function ajaxListProduct(){

        if($this->uri->segment(3)){
            $page = $this->uri->segment(3);
        }else{
            $page = 1;
        }
        $pagingConfigProduct   = $this->mypaginator->initPagination("/advertiser/metadata/ajaxListProduct",$this->product_model->record_count(),"/index.php/advertiser/ajaxListProduct/1");
        $data["pagination_helper"]   = $this->pagination;
        $data["listProduct"] = $this->product_model->get_by_range($page,$pagingConfigProduct['per_page']);
        if($this->input->post("isAjax")){
            $this->load->view("meta/list_product",$data);
        }else{
            $this->load->view("meta/product",$data);
        }
    }
    public function ajaxListSector(){

        if($this->uri->segment(3)){
            $page = $this->uri->segment(3);
        }else{
            $page = 1;
        }
        $pagingConfigSector   = $this->mypaginator->initPagination("/advertiser/metadata/ajaxListSector",$this->sector_model->record_count(),"/index.php/advertiser/ajaxListSector/1");
        $data["pagination_helper"]   = $this->pagination;
        $data["listSector"] = $this->sector_model->get_by_range($page,$pagingConfigSector['per_page']);
        if($this->input->post("isAjax")){

            $this->load->view("meta/list_sector",$data);
        }else{
            $this->load->view("meta/sector",$data);
        }
    }
    /**
     * @Decorated
     * MiTH
     */
    public function addMetaDataBrand(){
        $data = array();
        if(!$this->ion_auth->in_group('administrator'))
        {
            $this->session->set_flashdata('message','You are not allowed to visit this page');
//            redirect('welcome_message','refresh');
            $data['message'] = $this->session->flashdata('message');
        }

            $this->load->view("advertiser/meta_data", $data);

    }

    /*
     * *
     * Ajax add brand
     * @author MiTH
     * */
    public function ajaxAddBrand(){
        $brandName = $this->input->post('name');
        $date = date('YYYY-mm-dd H:i:s');

        if($brandName != ''){
            $data = array(
                'brand_name' => $brandName,
                'date_created' => $date
            );
            $addbrand = $this->brand_model->addBrand($data);
            if($addbrand){
                echo 1; die;
            }
            else
                echo 0;die;
        }else
            echo 0;die;
    }
    /*
     * *
     * Lấy danh sách Brand
     * @author MiTH
     * */
    public function  listBrand(){
        $list = $this->brand_model->listBrands();
        foreach($list as $brand){
            $php_array[] = array(
                'value' => $brand['id'],
                'text' => $brand['brand_name']
            );
        }
        echo json_encode($php_array);die;
    }

    /*
     * *
     * Lấy danh sách Product
     * @author MiTH
     * */
    public function  listProduct(){
        $list = $this->product_model->listPro();
        foreach($list as $product){
            $php_array[] = array(
                'value' => $product['id'],
                'text' => $product['product_name']
            );
        }
        echo json_encode($php_array);die;
    }
    /*
     * *
     * Ajax thêm product
     * @author MiTH
     * */
    public function ajaxAddProduct(){
        $productName = $this->input->post('name');
        $idBrand = (int)$this->input->post('id');
        $date = date('YYYY-mm-dd H:i:s');

        if($productName != ''){
            $data = array(
                'product_name' => $productName,
                'brand_id' => $idBrand,
                'date_created' => $date
            );
            $addPro = $this->product_model->addProduct($data);
            if($addPro){
                echo 1;die;
            }else
             echo 0;die;
        }else
            echo 0;die;
    }
    /*
     * *
     * Ajax thêm sector
     * @author MiTH
     * */
    public function ajaxAddSector(){
        $sectorName = $this->input->post('name');
        $idProduct = (int)$this->input->post('id');
        $date = date('YYYY-mm-dd H:i:s');

        if($sectorName != ''){
            $data = array(
                'sector_name' => $sectorName,
                'product_id' => $idProduct,
                'date_created' => $date
            );
            $addSector = $this->sector_model->addSector($data);
            if($addSector){
                echo 1;die;
            }else{
                echo 0;die;
            }

        }else
        {  echo 0;die; }
    }
    /*
     * *
     * Edit Brand
     * @author MiTH
     * */
    public function editBrand(){

        $brandName = $this->input->post('name');
        $brandId = (int)$this->input->post('id');
        $date = date('YYYY-mm-dd H:i:s');

        if($brandName != '' && $brandId !=''){
            $data = array(
                'brand_name' => $brandName,
                'id' => $brandId,
                'date_created' => $date
            );
           $isBrand = $this->brand_model->updateBrandById($data);
            if($isBrand)
                {echo 1;die;}
            else{
                {echo 0;die;}
            }
        }else{
            echo 0;die;
        }
    }
    /*
     * *
     * Edit product name editable by id
     * @author MiTH
     * */
    public function editProductByName(){
        $productName = $this->input->post('name');
        $productId = (int)$this->input->post('id');
        $date = date('YYYY-mm-dd H:i:s');
        $data = array(
            'product_name' => $productName,
            'id' => $productId,
            'date_created' => $date
        );
        $isProduct = $this->product_model->updateNameProductById($data);
        if($isProduct){
            echo 1;die;
        }else{
            echo 0;die;
        }
    }
    /*
     * *
     * Edit brand id editable for product
     * @author MiTH
     * */
    public function editBrandForProduct(){
        $brandName = $this->input->post('name');
        $productId = (int)$this->input->post('id');
        $date = date('YYYY-mm-dd H:i:s');
        $data = array(
            'id' => $productId,
            'brand_id' =>(int)$brandName,
            'date_created' => $date
        );
        $isBrand = $this->product_model->updateProductByBrandId($data);
        if($isBrand){
            echo 1;die;
        }else{
            echo 0;die;
        }

    }
    /*
     * *
     * Edit sector name by id
     * @author MiTH
     * */
    public function editSectorByName(){

        $sectorName = $this->input->post('name');
        $sectorId = (int)$this->input->post('id');
        $date = date('YYYY-mm-dd H:i:s');

            $data = array(
                'sector_name' => $sectorName,
                'id' => $sectorId,
                'date_created' => $date
            );
//        var_dump($data);die;
            $isSector = $this->sector_model->updateSectorByName($data);
            if($isSector){
                echo 1;die;
            }else{
                echo 0;die;
            }

    }
    /*
    * *
    * Edit sector name by id for product
    * @author MiTH
    * */
    public function editProductForSector(){
        $productName = $this->input->post('name');
        $sectorId = $this->input->post('id');
        $date = date('YYYY-mm-dd H:i:s');
        $data = array(
            'id' =>$sectorId,
            'product_id' =>$productName,
            'date_created' => $date
        );
        $this->sector_model->updateSectorByProduct($data);
        echo 1;die;

    }
    /*
      * *
      * Ajax add meta data
      * @author MiTH
      * */
    public function ajaxAddMetaData(){

        $brandName = $this->input->post('brandName');
        $productName = $this->input->post('productName');
        $sectorName = $this->input->post('sectorName');

        if($brandName !='' && $productName !='' && $sectorName !='' ) {
            $data = array(
                'brand_name' => $brandName
            );
            $checkBrand = $this->brand_model->checkNameBrand($brandName);
            if ($checkBrand) {
                $idBrand = $this->brand_model->addBrand($data);

            } else
            {
                $rowBrand = $this->brand_model->getIdBrandByName($brandName);
                $idBrand = $rowBrand[0]['id'];
            }
            $dataProduct = array(
                'brand_id' => (int)$idBrand,
                'product_name' => $productName
            );
            $checkProduct = $this->product_model->checkProduct($productName,$idBrand);
            if($checkProduct)
                $idProduct = $this->product_model->addProduct($dataProduct);
            else{
                $rowProduct = $this->product_model->getIdProductByName($productName);
                $idProduct = $rowProduct[0]['id'];
            }
            $checkSector = $this->sector_model->checkSector($sectorName,$idProduct);
            $dataSector = array(
                'product_id' => (int)$idProduct,
                'sector_name' => $sectorName
            );
            if($checkSector){
                $this->sector_model->addSector($dataSector);
            }

           echo 1; die;
        }else
            echo 0;die;
    }
}