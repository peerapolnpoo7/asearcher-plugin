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
		if(this.value=="2"){
			$('#AgeBrethren_'+idBox[1]).prop('disabled',true);
			$('#OccupationBrethren_'+idBox[1]).prop('disabled',true);
		}else{
			$('#AgeBrethren_'+idBox[1]).prop('disabled',false);
			$('#OccupationBrethren_'+idBox[1]).prop('disabled',false);
		}
	})

	var i = 0;
	$('form').request('onChildren',{
			success: function(data) {
				$('#btnRemove_C').attr('disabled', true);
					// console.log(data.length);
					i = data.length;
					if (i != 0) {
						$('#NumChildren').val(i);

						for (var k = 1; k <= i; k++) {
							if (k == 1) {
									$("#boxChildren").find('.row:first-child').removeClass('hidden');
							}else if (k >= 2) {
								$("#boxChildren").find('.row:last-child' ).clone().appendTo("#boxChildren");
								$("#boxChildren .row:last-child").find(".No").text(k);
								$("#boxChildren .row:last-child").find(".Children").each(function(){
									var idExp=this.id.split("_");
									$(this).attr('id',idExp[0]+'_'+k);
								});
							}
							$("#TitleNameChildren_"+k+" option[value='" + data[k-1].idPrefix +"']").attr("selected","selected");
							$("#NameChildren_"+k+"").val(data[k-1].FirstName_TH);
							$("#LastNameChildren_"+k+"").val(data[k-1].LastName_TH);
							$("#AgeChildren_"+k+"").val(data[k-1].Age);
						}
					}else {
						 i = 0;
						$('#NumChildren').val(i);
					}

					$("body").on('click','#btnAdd_C',function(){
						i = i + 1;
						if (i == 9) {
							$('#btnAdd_C').attr('disabled', true);
						}else {
							$('#btnAdd_C').attr('disabled', false);
						}

						if (i > data.length ) {
									$('#btnRemove_C').attr('disabled', false);
						}

						$('#NumChildren').val(i);
						$("#boxChildren").find('.row:first-child').removeClass('hidden');
						if (i >= 2) {
							$("#boxChildren").find('.row:last-child' ).clone().appendTo("#boxChildren").val("");
							$("#boxChildren .row:last-child").find(".No").text(i);
							$("#boxChildren .row:last-child").find(".Children").val("").each(function(){
								var idExp=this.id.split("_");
								$(this).attr('id',idExp[0]+'_'+i);
							});
						}
					}).on('click','#btnRemove_C',function(){
						if (i == 1 ) {
							$("#boxChildren").find('.row:first-child').addClass('hidden');
						}else {
							$("#boxChildren .row:last-child").remove();
						}
						i = i - 1;
						$('#NumChildren').val(i);

						if (data.length != 0) {
							if (data.length == i) {
			              $('#btnRemove_C').attr('disabled', true);
			        }else {
			              $('#btnRemove_C').attr('disabled', false);
			        }

							if (i != data.length) {
			              $('#btnAdd_C').attr('disabled', false);
			        }
						} else {
							if (i == 0) {
			              $('#btnRemove_C').attr('disabled', true);
			        }else {
			              $('#btnRemove_C').attr('disabled', false);
			        }

							if (i != 0) {
			              $('#btnAdd_C').attr('disabled', false);
			        }
						}

					})
			}
	});

	var j = 0;
	$('form').request('onBrethren',{
			success: function(data) {
				$('#btnRemove_B').attr('disabled', true);
					// console.log(data);
					j = data.length;
					if (j != 0) {
						$('#NumBrethren').val(j);

						for (var h = 1; h <= j; h++) {
							if (h == 1) {
									$("#boxBrethren").find('.row:first-child').removeClass('hidden');
							}else if (h >= 2) {
								$("#boxBrethren").find('.row:last-child' ).clone().appendTo("#boxBrethren");
								$("#boxBrethren .row:last-child").find(".No").text(h);
								$("#boxBrethren .row:last-child").find(".Brethren").each(function(){
									var idExp=this.id.split("_");
									$(this).attr('id',idExp[0]+'_'+h);
								});
							}
							$("#TitleNameBrethren_"+h+" option[value='" + data[h-1].idPrefix +"']").attr("selected","selected");
							$("#NameBrethren_"+h+"").val(data[h-1].FirstName_TH);
							$("#LastNameBrethren_"+h+"").val(data[h-1].LastName_TH);
							$("#BrethrenStatus_"+h+"").val(data[h-1].idLife_Status);
							$("#AgeBrethren_"+h+"").val(data[h-1].Age);
							$("#OccupationBrethren_"+h+"").val(data[h-1].idOccupation);

						}
					}else {
						 j = 0;
						$('#NumBrethren').val(j);
					}

					$("body").on('click','#btnAdd_B',function(){
						j = j + 1;
						if (j == 9) {
							$('#btnAdd_B').attr('disabled', true);
						}else {
							$('#btnAdd_B').attr('disabled', false);
						}

						if (j > data.length ) {
									$('#btnRemove_B').attr('disabled', false);
						}

						$('#NumBrethren').val(j);
						$("#boxBrethren").find('.row:first-child').removeClass('hidden');
						if (j >= 2) {
							$("#boxBrethren").find('.row:last-child' ).clone().appendTo("#boxBrethren");
							$("#boxBrethren .row:last-child").find(".No").text(j);
							$("#boxBrethren .row:last-child").find(".Brethren").val("").each(function(){
								var idExp=this.id.split("_");
								$(this).attr('id',idExp[0]+'_'+j);
							});
						}
					console.log(j);
						$("#TitleNameBrethren_"+j+" option[value='']").attr("selected","selected");
						$("#BrethrenStatus_"+j+" option[value='1']").attr("selected","selected");
						$("#OccupationBrethren_"+j+" option[value='']").attr("selected","selected");
					}).on('click','#btnRemove_B',function(){
						if (j == 1 ) {
							$("#boxBrethren").find('.row:first-child').addClass('hidden');
						}else {
							$("#boxBrethren .row:last-child").remove();
						}
						j = j - 1;
						$('#NumBrethren').val(j);

						if (data.length != 0) {
							if (data.length == j) {
										$('#btnRemove_B').attr('disabled', true);
							}else {
										$('#btnRemove_B').attr('disabled', false);
							}

							if (j != data.length) {
										$('#btnAdd_B').attr('disabled', false);
							}
						} else {
							if (j == 0) {
										$('#btnRemove_B').attr('disabled', true);
							}else {
										$('#btnRemove_B').attr('disabled', false);
							}

							if (j != 0) {
										$('#btnAdd_B').attr('disabled', false);
							}
						}

					})
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

		$('form').request('onStatusCandidate',{
				success: function(data) {
						// console.log(data.idMarital_Status);
						if (data.idMarital_Status != 1) {
								$('.boxMarital').removeClass('hidden');
						}
				}
		});






});
