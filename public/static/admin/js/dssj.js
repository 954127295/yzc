//侧边栏展开收缩
$(function() {
	$('.li-first').click(function(e) {
		console.log("");
		dropSwift($(this), '.li-firstDrop');	   
		e.stopPropagation();
	});

	function dropSwift(dom, drop) {
        dom.next().slideToggle();
		dom.parent().siblings().find(drop).slideUp();
				
	}
})

//保育育肥舍 编辑
$(function($){
	$(document).ready(function(){		
  $(".edit").click(function(){
  $(".edit-tc").show();
  });
  		
  $(".close,.ups-button").click(function(){
  $(".edit-tc").hide();
  });
});	
   });
   
//怀孕舍 编辑
$(function($){
	$(document).ready(function(){		
  $(".edit-hy").click(function(){
  $(".edit-hy-tc").show();
  });
  		
  $(".close,.ups-button").click(function(){
  $(".edit-hy-tc").hide();
  });
});	
   });   
   
 //哺育舍 编辑
$(function($){
	$(document).ready(function(){		
  $(".edit-by").click(function(){
  $(".edit-by-tc").show();
  });
  		
  $(".close,.ups-button").click(function(){
  $(".edit-by-tc").hide();
  });
});	
   });



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


   