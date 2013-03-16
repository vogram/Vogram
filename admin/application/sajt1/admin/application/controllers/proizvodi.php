<?php
class Proizvodi extends CI_Controller {

	public function __construct()
    {
		parent::__construct();
		
	}
	
	public function index()
	{
	
		redirect(site_url("proizvodi/kategorija"), 'refresh');
		
	}
	
	public function kategorija($category="sve",$page=0)
	{
		
		$this->load->model('model_proizvodi');
		$this->load->helper('form');
		if($category=="sve"){
		$category_id=$this->model_proizvodi->prvakategorija();
		}else{
			$category_id = explode("-",$category);
			$category_id = $category_id[0];
		}
		if ($page<=0){$page='0';}
		if ($page % 8 > 0){
			$page = (int)($page / 8);
		}
		//dodeljivanje vrednosti promenljivama koje se prosledjuju view_header-u
		$totalproducts=$this->model_proizvodi->totalproducts($category_id);
		//if ($page>($totalproducts-8)){$page=$totalproducts-8;}//mora biti deljivo sa 8!!!
		if($page<0){
		$page=0;
		}
		$proizvodi = $this->model_proizvodi->proizvodikategorija($category_id,$page);
		$urlkategorija=$this->model_proizvodi->urlkategorija($category_id);
		
		//var_dump($proizvodi);
		$option=array(
		
			"title"=>"Apoteka 9",
		);
		$option['proizvodi']=$proizvodi;
		$option['totalproducts']=$totalproducts;
		$option['page']=$page;
		$option['urlkategorija']=$urlkategorija;
		//$option['head'] .= $this->model_pretraga->jscript(site_url('isadv/pretraga'));
		//$option['input'] = $this->model_pretraga->input();
		
		//ucitavanje view_header sa promenljivama
		$this->load->view('view_header',$option);
		
		//ucitavanje view_isadv
		$this->load->view('view_proizvodi', $option);
				
	}
}