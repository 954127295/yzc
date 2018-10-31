
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
   
