<?php
/**
 * Created by PhpStorm.
 * User: mith
 * Date: 8/22/2016
 * Time: 11:26 AM
 */
class Index extends MY_Controller
{

    function __construct()
    {
        parent::__construct();

        $this->load->helper(array('form', 'url'));
    }

    public function addNews()
    {
        $this->render('admin/news_add', 'admin');
    }
}


