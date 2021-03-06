<?php

class News_management extends MY_Controller{
	
	function __construct(){
		parent::__construct();
		$this->load->model('news_model');
	}

	function index(){
		if($this->input->get('news_sort_by') == 'nTitle') {
			$data['news'] = $this->news_model->news_list("title",$this->input->get('news_type'));
		} elseif($this->input->get('news_sort_by') == 'nContent') {
			$data['news'] = $this->news_model->news_list("content",$this->input->get('news_type'));
		} else {
			$data['news'] = $this->news_model->news_list('nothing','nothing');
		}
		$this->load->view('news_panel', $data );
	}

	function add(){
		$this->load->view('add_news');
	}

	function add_news(){
		$this->news_model->add_news();
		redirect('admin/news_management');
	}

	function edit(){
		$id = $this->input->get('id');
		$data['new'] = $this->news_model->get_new($id);
		$this->load->view('edit_news', $data);
	}

	function update(){
		$this->news_model->update();
		redirect('admin/news_management');
	}

	function remove_news(){
		$this->load->model('news_model');
		$this->news_model->remove();
		$this->index();
	}
}
