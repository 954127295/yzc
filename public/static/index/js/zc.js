
//报警信息
$(function($){
	$(document).ready(function(){		
  $(".alarm").click(function(){
  $(".alarm-tc").show();
  });
  		
  $(".close").click(function(){
  $(".alarm-tc").hide();
  });
});	
   });
   
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
   
   
//详情页报警信息
$(function($){
	$(document).ready(function(){		
  $(".alarm1").click(function(){
  $(".alarm1-tc").show();
  });
  		
  $(".close").click(function(){
  $(".alarm1-tc").hide();
  });
});	
   });