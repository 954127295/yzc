<?php
	function get_menu($c,$a){
		$user = session("user");
		$pers = db("Permission")->where(array("show"=>"yes"))->select();
		$html = '';
		foreach($pers as $p){
			$p_arr = explode(",",$p['per']);
			if(in_array($user['permission'],$p_arr)){
				if($c == $p['controller'] && $a == $p['function']){
					$html .= '<li class="sid_checked">'.$p['name'].'</li>';
				}else{
					// $url = url("'".$p['controller']."/".$p['function']."'");
					$url = url($p['controller']."/".$p['function']);
					$html .= '<a href="'.$url.'"><li>'.$p['name'].'</li></a>';

					http://www.yzc_sy.com/index.php/index/'_index/ceshi'.html

				}
			}else{
				$url = url('alluse/error_show');
				$html .= '<a href="'.$url.'"><li>'.$p['name'].'</li></a>';
			}
		}
		return $html;
	}