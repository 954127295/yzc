
//添加
$(function($){
	$(document).ready(function(){		
  $(".addto").click(function(){
  $(".addto-tc").show();
  });
  		
  $(".close,.ups-button").click(function(){
  $(".addto-tc").hide();
  });
});	
   });
   
 //修改信息
 $(function($){
	$(document).ready(function(){		
  $(".modify").click(function(){
  $(".modify-tc").show();
  });
  		
  $(".close,.ups-button").click(function(){
  $(".modify-tc").hide();
  });
});	
   });
   
  //删除信息 
   $(function($){
	$(document).ready(function(){		
  $(".delete").click(function(){
  $(".delete-tc").show();
  });
  		
  $(".close,.ups-button").click(function(){
  $(".delete-tc").hide();
  });
});	
   });
//下拉菜单
function displaySubMenu(li) {
    var subMenu = li.getElementsByTagName("ul")[0];
    subMenu.style.display = "block";
}
function hideSubMenu(li) {
    var subMenu = li.getElementsByTagName("ul")[0];
    subMenu.style.display = "none";
}
//修改密码
$(function($){
    $(document).ready(function(){
        $(".change-password").click(function(){
            $(".change-password-s").show();
        });

        $(".close,.ups-button").click(function(){
            $(".change-password-s").hide();
        });
    });
});
//修改用户信息
$(function($){
    $(document).ready(function(){
        $(".change-info").click(function(){
            $(".change-info-s").show();
        });

        $(".close,.ups-button").click(function(){
            $(".change-info-s").hide();
        });
    });
});

