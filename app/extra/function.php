<?php
	function get_menu($c,$a){
		$user = session("user");
		$pers = db("Permission")->select();
		$html = '';
		foreach($pers as $p){
			$p_arr = explode(",",$p['per']);
			if(in_array($user['permission'],$p_arr)){
				if($c == $p['controller'] && $a == $p['function']){
					$html .= '<li class="sid_checked">'.$p['name'].'</li>';
				}else{
					$url = "/index/".$p['controller']."/".$p['function'];
					$html .= '<a href="'.$url.'"><li>'.$p['name'].'</li></a>';
				}
			}else{
				$url = "/index/Public/error";
				$html .= '<a href="'.$url.'"><li>'.$p['name'].'</li></a>';
			}
		}
		return $html;
	}