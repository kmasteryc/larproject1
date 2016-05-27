<?php
/**
 * Created by PhpStorm.
 * User: kmasteryc
 * Date: 22/05/2016
 * Time: 17:43
 */

namespace Tools;

class Menu
{
	protected $_open = "";
	protected $_close = "";
	protected $_openitem = "";
	protected $_closeitem = "";
	protected $_baseurl;
	protected $_data;
	protected $_result = "";

	protected $_config = array(
		"open" => "",
		"close" => "",
		"openitem" => "",
		"closeitem" => "",
		"baseurl" => "http://www.qhonline.edu.vn/viewcate",
	);
//
//	public function __construct($config = "")
//	{
//		if ($config != "") {
//			$this->setOption($config);
//		}
//	}

	public function show_menu($menu, $config = '')
	{
		foreach ($menu as $value) {
			$pa = $value['cate_parent'];
			$this->_data[$pa][] = $value;
		}

		$config != '' ? $this->setOption($config) : $this->setOption($this->_config);

		return $this->callMenu();
	}

	public function setOption($config)
	{
		foreach ($config as $k => $value) {
			$method = "set" . ucfirst($k);
			$this->$method($value);
		}
	}

	public function setOpen($tag)
	{
		$this->_open = $tag;
	}

	public function setClose($tag)
	{
		$this->_close = $tag;
	}

	public function setOpenitem($tag)
	{
		$this->_openitem = $tag;
	}

	public function setCloseitem($tag)
	{
		$this->_closeitem = $tag;
	}

	public function setBaseurl($url)
	{
		$this->_baseurl = $url;
	}

	public function setMenu($menu)
	{
		foreach ($menu as $value) {
			$pa = $value['cate_parent'];
			$this->_data[$pa][] = $value;
		}
	}

	public function callMenu($cate_parent = 0)
	{
		if (isset($this->_data[$cate_parent])) {
			$this->_result .= $this->_open;
			foreach ($this->_data[$cate_parent] as $k => $value) {
				$id = $value['id'];
				$this->_result .= "<tr><td>$id</td>";
				if (isset($this->_data[$id])) {
					$this->_result .= "<td>---- " . $value['cate_title'] . "</td>";
				} else {
					$this->_result .= "<td>-- " . $value['cate_title'] . "</td>";
				}

				$this->_result .= "<td><a href='" . url("cate/$id/edit") . "'>Edit</a> - <a href='" . url("cate/$id/delete") . "'>Delete</a></td>";

				$this->callMenu($id);

				$this->_result .= "</tr>";
			}
			$this->_result .= $this->_close;
		}
		return $this->_result;
	}

//	public function callMenu($cate_parent = 0)
//	{
//		if (isset($this->_data[$cate_parent])) {
//			$this->_result .= $this->_open;
//			foreach ($this->_data[$cate_parent] as $k => $value) {
//				$this->_result .= $this->_openitem;
//				$id = $value['id'];
//				if (isset($this->_data[$id])) {
//					$this->_result .= "" . $value['cate_title'] . "";
//				} else {
//					$this->_result .= "" . $value['cate_title'] . "";
//				}
//				$this->callMenu($id);
//				$this->_result .= $this->_closeitem;
//			}
//			$this->_result .= $this->_close;
//		}
//		return $this->_result;
//	}
//

}