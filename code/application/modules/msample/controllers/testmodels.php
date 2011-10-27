<?php
class TestModels extends MY_Controller {
	public function testFindModel() {
		$this->load->model('amodel');
		$this->db->query();
		$this->amodel->getproducts();
	}
}
