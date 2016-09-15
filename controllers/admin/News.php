<?php
/**
 * Created by PhpStorm.
 * User: mith
 * Date: 8/9/2016
 * Time: 4:36 PM
 */
class News extends MY_Controller
{

    function __construct()
    {
        parent::__construct();

        $this->load->helper(array('form', 'url'));
        $this->load->model('mnews');
    }

    public function addNews(){

        $this->render('admin/news_add','admin');
    }

    public function uploadNews()
    {
        $this->form_validation->set_rules('title', 'Title', 'required');
        $this->form_validation->set_rules('content', 'Content', 'required');
        $this->form_validation->set_rules('desc', 'Description', 'required');

        if($this->form_validation->run()===TRUE){
            $config = array();
            $config['upload_path'] = './uploads/news';
            $config['allowed_types'] = 'gif|jpg|png';

            $this->load->library('upload', $config);
            if ( ! $this->upload->do_upload('images')) {
                $error = array('error' => $this->upload->display_errors());
                $this->load->view('news_add', $error);
            }

            else {
                $data = $this->upload->data();
                $title = $this->input->post('title');
                $desc = $this->input->post('desc');
                $content = $this->input->post('content');

                $data = array(
                    'title' => $title,
                    'description' => $desc,
                    'content' => $content,
                    'image' => $data['file_name']
                );
//                var_dump($data);die;
                $addnews = $this->mnews->addNews($data);
                if($addnews)
                    redirect("/admin/news/getListNews");
            }
        }

    }

    public function getListNews(){

        $this->data['news'] = $this->mnews->getListNews();

        $this->render('admin/news_list','admin');
    }
}