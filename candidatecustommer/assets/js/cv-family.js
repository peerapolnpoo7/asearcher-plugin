$(document).ready(function(){
	$("body").on('click','input[name="typeMilitary"]',function(){
		if ($('#radioOther').is(':checked')) {
			$('#detailMilitary').prop('disabled',false);
		}else{
			$('#detailMilitary').prop('disabled',true);
		}
	}).on('click','input[name="typeMarital"]',function(){
		if ($('#สมรส').is(':checked') || $('#หย่า').is(':checked') || $('#หม้าย').is(':checked') || $('#แยกกันอยู่').is(':checked') ){
			$('.boxMarital').removeClass('hidden');
			$("#boxChildren").removeClass('hidden');
		}else{
			$('.boxMarital').addClass('hidden');
			$("#boxChildren").addClass('hidden');
		}

		if ($('#หม้าย').is(':checked')){
			$('.widow').prop('disabled',true);
			$('#idCountry_Calling_Code_Spouse').prop('disabled', true).trigger("chosen:updated");
		}else{
			$('.widow').prop('disabled',false);
			$('#idCountry_Calling_Code_Spouse').prop('disabled', false).trigger("chosen:updated");
		}


	}).on("change","#Status_Father",function(){
		if(this.value=="1"){
			$('.FatherRelateStatus').prop('disabled',true);
			$('#idCountry_Calling_Code_Father').prop('disabled', true).trigger("chosen:updated");
		}else{
			$('.FatherRelateStatus').prop('disabled',false);
			$('#idCountry_Calling_Code_Father').prop('disabled', false).trigger("chosen:updated");
		}
	}).on("change","#Status_Mother",function(){
		if(this.value=="1"){
			$('.MotherRelateStatus').prop('disabled',true);
			$('#idCountry_Calling_Code_Mother').prop('disabled', true).trigger("chosen:updated");
		}else{
			$('.MotherRelateStatus').prop('disabled',false);
			$('#idCountry_Calling_Code_Mother').prop('disabled', false).trigger("chosen:updated");
		}
	}).on("keyup","#NumChildren",function(){



		$("#boxChildren").find('.row:not(:first-child)').remove();
		if(this.value=="" || this.value=="0"){
			$("#boxChildren").find('.row:first-child').addClass('hidden');
		}else{
			$("#boxChildren").find('.row:first-child').removeClass('hidden');
			if(this.value > 1){
				// $("#boxChildren").find('.row:first-child label:contains("{=id=}")').text(1+".คำนำหน้าชื่อ");
				// for(var i=2;i<=this.value;i++){
				// 	$("#boxChildren").find('.row:last-child').clone().appendTo("#boxChildren");
				// 	$("#boxChildren").find('.row:last-child label:contains("{=id=}")').text(i+".คำนำหน้าชื่อ");
				// }
				for(var i=2;i<=this.value;i++){
					$("#boxChildren").find('.row:last-child' ).clone().appendTo("#boxChildren");
					$("#boxChildren .row:last-child").find(".No").text(i);
					$("#boxChildren .row:last-child").find(".Children").each(function(){
						var idExp=this.id.split("_");
						$(this).attr('id',idExp[0]+'_'+i);
						// $(".chosen").chosen({width: "100%"});
						// $(".chosen").trigger("chosen:updated");
					});
				}
			}
		}
	}).on("keyup","#NumBrethren",function(){
		$("#boxBrethren").find('.row:not(:first-child)').remove();
		if(this.value=="" || this.value=="0"){
			$("#boxBrethren").find('.row:first-child').addClass('hidden');
		}else{
			$("#boxBrethren").find('.row:first-child').removeClass('hidden');
			if(this.value > 1 ){
				for(var i=2;i<=this.value;i++){
					$("#boxBrethren").find('.row:last-child' ).clone().appendTo("#boxBrethren");
					$("#boxBrethren .row:last-child").find(".No").text(i);
					$("#boxBrethren .row:last-child").find(".Brethren").each(function(){
						var idExp=this.id.split("_");
						$(this).attr('id',idExp[0]+'_'+i);
					});
				}
			}
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

	var now = new Date();
	$('.BirthDate').scroller({
			theme: 'android-ics light',
			startYear: now.getFullYear()-100,
			endYear: now.getFullYear()-18,
	});
	$('.dateMobileStart').scroller({
			theme: 'android-ics light',
			startYear: now.getFullYear()-100,
			endYear: now.getFullYear(),
	});
	$('.dateMobileEnd').scroller({
			theme: 'android-ics light',
			startYear: now.getFullYear()-100,
			endYear: now.getFullYear(),
	});
	$('select.chosen').chosen({
				width: "100%",
				search_contains: true
		});
		$('.chosen-select').chosen({width: "100%",height:"100%"});

});
