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

	protected $_open="<tr>";
	protected $_close="</tr>";
	protected $_openitem="<td>";
	protected $_closeitem="</td>";
	protected $_baseurl;
	protected $_data;
	protected $_data2;
	protected $_result="";
	protected $_select='';

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
	public function make($menu,$type,$select=''){

		foreach($menu as $value){
			$pa=$value['cate_parent'];
			$this->_data[$pa][]=$value;
		}
		$this->_data2 = $menu;
		// Assign default select
		if ($select) $this->_select = $select;
		// Call menu depending on select or td
		$type = "call_menu_".$type;
		$temp = $this->$type();
		// Reset after assign for calling other menu
		$this->_result = '';
		$this->_data = '';
		$this->_select = '';

		return $temp;
	}
	public function call_menu_td($cate_parent=0)
	{
		if (isset($this->_data[$cate_parent])) {

			foreach ($this->_data[$cate_parent] as $k => $value) {
				$this->_result .= '<tr>';
				$id = $value['id'];
				$this->_result .= '<td>'.$id.'</td>';

				$this->_result .= "<td><a href='".url("cate/$id/edit")."'>Edit</a> - <a href='".url("cate/$id/delete")."'>Delete</a></td>";

//				if (isset($this->_data[$id]) || $value['cate_parent'] == 0) {
				if (isset($this->_data[$id]) || $value['cate_parent'] == 0) {
					$this->_result .= "<td><b>---". $value['cate_title'] . "</b></td>";
				}
				else {
					$this->_result .= "<td>-".$value['cate_title'] . "</td>";
				}


				$this->call_menu_td($id);
				$this->_result .= '</tr>';
			}

		}
		return $this->_result;
	}
	public function call_menu_slc($cate_parent=0)
	{
		if (isset($this->_data[$cate_parent])) {

			foreach ($this->_data[$cate_parent] as $k => $value) {

				$id = $value['id'];

				$select = $this->_select == $value['id'] && $this->_select ? "selected" : '';

				$this->_result .= "<option value='$id' $select>";

				if (isset($this->_data[$id])) {
					$this->_result .= "<td><b>---". $value['cate_title'] . "</b></td>";
				} else {
					$this->_result .= "<td>".$value['cate_title'] . "</td>";
				}

				$this->_result .= '</option>';

				$this->call_menu_slc($id);
			}

		}
		return $this->_result;
	}
	public function call_menu_nav($cate_parent=0)
	{
//		dd($this->_data);
		if (isset($this->_data[$cate_parent])) {

			foreach ($this->_data[$cate_parent] as $value) {

				$id = $value['id'];
				$this->_result .= "<li class='column'>";
				$this->_result .= "<div class='clearfix'><b class='blue-foot'><a href='".url('/chu-de/'.$value['id'])."'>". $value['cate_title'] . "</a></b>";
				foreach ($this->_data2 as $child)
				{
					if ($child['cate_parent'] == $id)
					{
						$this->_result .= "<p><a href='".url('/chu-de/'.$child['id'])."'>".$child['cate_title'] . "</a></p>";
					}
				}
//				$this->call_menu_nav($id);
				$this->_result .= '</li>';


			}

		}
		return $this->_result;
	}

	public function call_menu_nav2($cate_parent=0)
	{

		if (isset($this->_data[$cate_parent])) {

			foreach ($this->_data[$cate_parent] as $value) {

				$id = $value['id'];
				$this->_result .= '<li class="dropdown dropdown-large">';
				$this->_result .= '<a href="'.url('/chu-de/'.$value['cate_title_slug'].'.html').'" class="dropdown-toggle" data-toggle="dropdown" role="button">'.$value['cate_title'].'</a>';
				$this->_result .= '<ul class="dropdown-menu dropdown-menu-large row">';
				foreach ($this->_data2 as $child)
				{
					if ($child['cate_parent'] == $id)
					{
                        $this->_result .= '';
						$this->_result .= '<li><a href="'.url('/chu-de/'.$child['cate_title_slug'].'.html').'">'.$child['cate_title'].'</a></li>';
					}
				}
				$this->_result .= '<li role="separator" class="divider"></li>';
				$this->_result .= '<li><a href="'.url('/chu-de/'.$value['cate_title_slug'].'.html').'">'.$value['cate_title'].'</a></li>';
				$this->_result .= '</ul></li>';
			}

		}
		return $this->_result;
	}

    public function call_menu_nav3($cate_parent=0)
    {

        if (isset($this->_data[$cate_parent])) {

            foreach ($this->_data[$cate_parent] as $value) {

                $id = $value['id'];
                $this->_result .= '<li class="dropdown hidden-xs">';
                $this->_result .= '<a href="'.url('/chu-de/'.$value['cate_title_slug'].'.html').'" class="dropdown-toggle" data-toggle="dropdown" role="button">'.$value['cate_title'].'</a>';
                $this->_result .= '<ul class="dropdown-menu">';
                foreach ($this->_data2 as $child)
                {
                    if ($child['cate_parent'] == $id)
                    {
                        $this->_result .= '<li><a href="'.url('/chu-de/'.$child['cate_title_slug'].'.html').'">'.$child['cate_title'].'</a></li>';
                    }
                }
                $this->_result .= '<li role="separator" class="divider"></li>';
                $this->_result .= '<li><a href="'.url('/chu-de/'.$value['cate_title_slug'].'.html').'">'.$value['cate_title'].'</a></li>';
                $this->_result .= '</ul></li>';
            }

        }
        return $this->_result;
    }
}