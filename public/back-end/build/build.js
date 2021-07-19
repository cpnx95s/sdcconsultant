
$('#header-tooltip').on('click',function(){ 
	if(c!=''){ 
		localStorage.setItem('theme',''); 		
	}else{
		localStorage.setItem('theme','c-dark-theme'); 
	} 
	if($('.c-icon').hasClass('c-dark-theme')){ $('.c-icon').removeClass('c-dark-theme');}else{ $('.c-icon').addClass('c-dark-theme') }
});
$(function(){
	if(localStorage.getItem('theme')==''){
		$('.c-icon').removeClass('c-dark-theme');
	}else{
		$('.c-icon').addClass('c-dark-theme');
	}
})

