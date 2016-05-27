<?php
class Menu{
	protected $_open="<ul class='menu'>";
	protected $_close="</ul>";
	protected $_openitem="<li>";
	protected $_closeitem="</li>";
	protected $_baseurl;
	protected $_data; 
	protected $_result="";
	
	public function __construct($config=""){
		if($config != ""){
			$this->setOption($config);
		}
	}
	
	public function setOption($config){
		foreach($config as $k=>$value){
			$method="set".ucfirst($k);
			$this->$method($value);
		}
	}
	
	public function setOpen($tag){
		$this->_open=$tag;
	}
	public function setClose($tag){
		$this->_close=$tag;
	}
	public function setOpenitem($tag){
		$this->_openitem=$tag;
	}
	public function setCloseitem($tag){
		$this->_closeitem=$tag;
	}
	public function setBaseurl($url){
		$this->_baseurl=$url;
	}
	public function setMenu($menu){
		foreach($menu as $value){
			$pa=$value['parent'];
			$this->_data[$pa][]=$value;
		}
	} 	
	public function callMenu($parent=0){
		if(isset($this->_data[$parent])){
			$this->_result.= $this->_open;
			foreach($this->_data[$parent] as $k=>$value){
				$this->_result.= $this->_openitem;
				$id=$value['id'];
				if(isset($this->_data[$id])){
					$this->_result.= "<a href='javascript:void()' class='link'>".$value['name']."</a>";
				}else{
					$this->_result.= "<a href='$this->_baseurl/$id'>".$value['name']."</a>";
				}
				$this->callMenu($id);
				$this->_result.= $this->_closeitem;
			}
			$this->_result.= $this->_close;
		}
		return $this->_result;
	}
}

