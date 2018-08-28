$(document).ready(function(){
	$("body").on('click','#btnAddForm',function(){
		$("#boxEducation").append('<hr>');
		$("#boxEducation").find('.row:first-child').clone().appendTo("#boxEducation");
	});
});