$(document).ready(function(){
	$("body").on('click','input[name="typeMilitary"]',function(){
		if ($('#radioOther').is(':checked')) {
			$('#detailMilitary').prop('disabled',false);
		}else{
			$('#detailMilitary').prop('disabled',true);
		}
	}).on('click','input[name="typeMarital"]',function(){
		if ($('#สมรส').is(':checked')) {
			$('.boxMarital').removeClass('hidden');
		}else{
			$('.boxMarital').addClass('hidden');
		}
	}).on("change","#StatusFather",function(){
		if(this.value=="1"){
			$('.FatherRelateStatus').prop('disabled',true);
		}else{
			$('.FatherRelateStatus').prop('disabled',false);
		}
	}).on("change","#StatusMother",function(){
		if(this.value=="1"){
			$('.MotherRelateStatus').prop('disabled',true);
		}else{
			$('.MotherRelateStatus').prop('disabled',false);
		}
	}).on("keyup","#NumChildren",function(){
		$("#boxChildren").find('.row:not(:first-child)').remove();
		if(this.value=="" || this.value=="0"){
			$("#boxChildren").find('.row:first-child').addClass('hidden');
		}else{
			$("#boxChildren").find('.row:first-child').removeClass('hidden');
			if(this.value > 1){
				$("#boxChildren").find('.row:first-child label:contains("{=id=}")').text(1+".คำนำหน้าชื่อ");
				for(var i=2;i<=this.value;i++){
					$("#boxChildren").find('.row:last-child').clone().appendTo("#boxChildren");
					$("#boxChildren").find('.row:last-child label:contains("{=id=}")').text(i+".คำนำหน้าชื่อ");
				}
				// $("#boxChildren").find('.row:first-child label:contains("{=id=}")').text(1+".คำนำหน้าชื่อ");
			}
		}
	}).on("keyup","#NumBrethren",function(){
		$("#boxBrethren").find('.row:not(:first-child)').remove();
		if(this.value=="" || this.value=="0"){
			$("#boxBrethren").find('.row:first-child').addClass('hidden');
		}else{
			$("#boxBrethren").find('.row:first-child').removeClass('hidden');
			if(this.value >= 1){


				for(var i=1;i<this.value;i++){
					console.log(i);
					$("#boxBrethren").find('.row:last-child' ).clone().appendTo("#boxBrethren");
					$("#boxBrethren").find('.row:last-child label:contains("{=id=}")').text(i+".คำนำหน้าชื่อ");
					// $("#boxBrethren .row:last-child").find(".Brethren").each(function(){
					// 	var idReplace=this.id.replace("{=id=}",i);
					// 	console.log(idReplace);
					// 	$(this).attr('id',idReplace);
					// });
				}








				// for(var i=2;i<=this.value;i++){
				// 	$("#boxBrethren").find('.row:first-child' ).clone().appendTo("#boxBrethren");
				// 	$("#boxBrethren").find('.row:last-child label:contains("{=id=}")').text(i+".คำนำหน้าชื่อ");
				// 	$("#boxBrethren .row:last-child").find(".Brethren").each(function(){
				// 		var idReplace=this.id.replace("{=id=}",i);
				// 		console.log(idReplace);
				// 		$(this).attr('id',idReplace);
				// 	});
				// }
								// $("#boxBrethren").find('.row:first-child label:contains("{=id=}")').text(1+".คำนำหน้าชื่อ");
								// $("#boxBrethren .row:first-child").find(".Brethren").each(function(){
								// 	var idReplace=this.id.replace("{=id=}",1);
								// 	console.log(idReplace);
								// 	$(this).attr('id',idReplace);
								// });
			}
				// 	if(this.value == 1){
				// 	$("#boxBrethren").find('.row:first-child label:contains("{=id=}")').text(1+".คำนำหน้าชื่อ");
				// 	$("#boxBrethren .row:first-child").find(".Brethren").each(function(){
				// 		var idReplace=this.id.replace("{=id=}",1);
				// 		console.log(idReplace);
				// 		$(this).attr('id',idReplace);
				// 	});
				// }
		}
	}).on("change",".BrethrenStatus",function(){
		var idBox=this.id.split("_");
		if(this.value=="1"){
			$('#AgeBrethren_'+idBox[1]).prop('disabled',true);
			$('#OccupationBrethren_'+idBox[1]).prop('disabled',true);
		}else{
			$('#AgeBrethren_'+idBox[1]).prop('disabled',false);
			$('#OccupationBrethren_'+idBox[1]).prop('disabled',false);
		}
	});
});
