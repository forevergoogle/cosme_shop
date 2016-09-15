<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Welcome extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->controllerName = $this->router->fetch_class();
        $this->methodName = $this->router->fetch_method();
    }

    /**
     * Check user login
     * @author Mith
     */
    public function index()
    {

    }

}