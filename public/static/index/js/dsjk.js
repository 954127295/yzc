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

//动物免疫 
$(function($){
	$(document).ready(function(){		
  $(".z-entry").click(function(){
  $(".z-entry-tc").show();
  });
  		
  $(".close,.ups-button").click(function(){
  $(".z-entry-tc").hide();
  });
});	
   });
   
//动物治疗 
$(function($){
	$(document).ready(function(){		
  $(".cure").click(function(){
  $(".cure-tc").show();
  });
  		
  $(".close,.ups-button").click(function(){
  $(".cure-tc").hide();
  });
});	
   });
   
 
   