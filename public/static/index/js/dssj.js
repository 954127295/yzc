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
// $(function($){
// 	$(document).ready(function(){		
//   $(".edit").click(function(){
//   $(".edit-tc").show();
//   });
  		
//   $(".close,.ups-button").click(function(){
//   $(".edit-tc").hide();
//   });
// });	
//    });
   
//怀孕舍 编辑
$(function($){
	$(document).ready(function(){		
  $(".edit-hy").click(function(){
    var x = $(this).find("#hid").val();
    $("#eb_id").val($(this).text());
    $("#edit_id").val(x);
    var tc = $(this).next("td").text();
    $("input[name='tc']").val(tc);
    var bq = $(this).next().next().next().next().text();
    $("#biaoq").val(bq);
    var pz = $(this).next().next().text();
    if(pz != ""){
      $("#peizhong").prop("checked",true);
    }
    var out_reason = $(this).next().next().next().next().next().next().next().next().text();
    if(out_reason == "流产"){
      $(".liuchan").prop("checked",true);
    }
    if(out_reason == "死亡"){
      $(".siwang").prop("checked",true);
    }
    if(out_reason == "转出"){
      $(".zhuanchu").prop("checked",true);
    }
  $(".edit-hy-tc").show();
  });
  $(".close,.ups-button").click(function(){
      $(".liuchan").prop("checked",false);
      $(".siwang").prop("checked",false);
      $(".zhuanchu").prop("checked",false);
    $("#peizhong").prop("checked",false);
  $(".edit-hy-tc").hide();
  });
});	
   });   
   
 //哺育舍 编辑
// $(function($){
// 	$(document).ready(function(){		
//   $(".edit-by").click(function(){
//   $(".edit-by-tc").show();
//   });
  		
//   $(".close,.ups-button").click(function(){
//   $(".edit-by-tc").hide();
//   });
// });	
//    });



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

//侧边栏展开收缩
$(function() {
    $('.li-first2').click(function(e) {
        console.log("");
        dropSwift($(this), '.li-firstDrop2');
        e.stopPropagation();
    });

    function dropSwift(dom, drop) {
        dom.next().slideToggle();
        dom.parent().siblings().find(drop).slideUp();

    }
})

   