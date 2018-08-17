$(document).ready(function(){
	$("body").on('click','.save',function(){
		// $('form').request('onSave', {
		//
		// 		success: function(data) {
		// 				console.log(data);
		// 		}
		// });


	}).on('click','input[name="typeMilitary"]',function(){
		if ($('#radioOther').is(':checked')) {
			$('#detailMilitary').prop('disabled',false);
		}else{
			$('#detailMilitary').prop('disabled',true);
		}
	}).on('click','input[name="typeMarital"]',function(){
		if ($('#สมรส').is(':checked') || $('#หย่า').is(':checked') || $('#หม้าย').is(':checked') || $('#แยกกันอยู่').is(':checked') ){
			$('.boxMarital').removeClass('hidden');
			$("#boxChildren").removeClass('hidden');
			$('#ไม่ได้จดทะเบียนสมรส').prop('checked',true);
		}else{
			$('.boxMarital').addClass('hidden');
			$("#boxChildren").addClass('hidden');
			$('#ไม่ได้จดทะเบียนสมรส').prop('checked',false);
		}

		if ($('#หม้าย').is(':checked')){
			$('.widow').prop('disabled',true);
			$('#idCountry_Calling_Code_Spouse').prop('disabled', true).trigger("chosen:updated");
			$('#idOccupation_Spouse').val('');
			$('#Age_Spouse').val('');
			$('#TelephoneNumber_Spouse').val('');
		}else{
			$('.widow').prop('disabled',false);
			$('#idCountry_Calling_Code_Spouse').prop('disabled', false).trigger("chosen:updated");
		}


	}).on("change","#Status_Father",function(){
		if(this.value=="2"){
			$('.FatherRelateStatus').prop('disabled',true);
			$('#idCountry_Calling_Code_Father').prop('disabled', true).trigger("chosen:updated");
		}else{
			$('.FatherRelateStatus').prop('disabled',false);
			$('#idCountry_Calling_Code_Father').prop('disabled', false).trigger("chosen:updated");
		}
	}).on("change","#Status_Mother",function(){
		if(this.value=="2"){
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
				for(var i=2;i<=this.value;i++){
					$("#boxChildren").find('.row:last-child' ).clone().appendTo("#boxChildren");
					$("#boxChildren .row:last-child").find(".No").text(i);
					$("#boxChildren .row:last-child").find(".Children").each(function(){
						var idExp=this.id.split("_");
						$(this).attr('id',idExp[0]+'_'+i);
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
	})


	var i = 0
	$("body").on('click','#btnAddForm',function(){
		i = i + 1;
		$('#NumChildren').val(i);

		$("#boxChildren").find('.row:first-child').removeClass('hidden');
		// // $("#boxChildren").append('<hr>');
		if (i >= 2) {
			$("#boxChildren").find('.row:last-child' ).clone().appendTo("#boxChildren");
			$("#boxChildren .row:last-child").find(".No").text(i);
			$("#boxChildren .row:last-child").find(".Children").each(function(){
				var idExp=this.id.split("_");
				$(this).attr('id',idExp[0]+'_'+i);
			});
		}


	}).on('click','#btnRemoveForm',function(){
		i = i - 1;
		$('#NumChildren').val(i);
		$("#boxChildren .row:last-child").remove();
	})

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


		// $('form').request('onCandidate',{
		// 		success: function(data) {
		// 				console.log(data);
		// 				if (data.idGender == 2) {
		// 						$('.boxMilitary').addClass('hidden');
		// 				}
		// 		}
		// });
		//
		$('form').request('onStatusCandidate',{
				success: function(data) {
						console.log(data.idMarital_Status);
						if (data.idMarital_Status != 1) {
								$('.boxMarital').removeClass('hidden');
						}
				}
		});






});
