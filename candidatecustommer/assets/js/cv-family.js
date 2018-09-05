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
		if ($('#Married').is(':checked') || $('#Divorced').is(':checked') || $('#Windowed').is(':checked') || $('#Separated').is(':checked') ){
			$('.boxMarital').removeClass('hidden');
			$('#Unregistered').prop('checked',true);
		}else{
			$('.boxMarital').addClass('hidden');
			$('#Unregistered').prop('checked',false);
		}

		if ($('#Windowed').is(':checked')){
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
			$('.FatherRelateStatus').val('').prop('disabled',true);
			$('#idCountry_Calling_Code_Father').prop('disabled', true).trigger("chosen:updated");
		}else{
			$('.FatherRelateStatus').prop('disabled',false);
			$('#idCountry_Calling_Code_Father').prop('disabled', false).trigger("chosen:updated");
		}
	}).on("change","#Status_Mother",function(){
		if(this.value=="2"){
			$('.MotherRelateStatus').val('').prop('disabled',true);
			$('#idCountry_Calling_Code_Mother').prop('disabled', true).trigger("chosen:updated");
		}else{
			$('.MotherRelateStatus').prop('disabled',false);
			$('#idCountry_Calling_Code_Mother').prop('disabled', false).trigger("chosen:updated");
		}
	})

	// .on("change",".BrethrenStatus",function(){
	// 	var idBox=this.id.split("_");
	// 	if(this.value=="2"){
	// 		$('#AgeBrethren_'+idBox[1]).prop('disabled',true);
	// 		$('#OccupationBrethren_'+idBox[1]).prop('disabled',true);
	// 	}else{
	// 		$('#AgeBrethren_'+idBox[1]).prop('disabled',false);
	// 		$('#OccupationBrethren_'+idBox[1]).prop('disabled',false);
	// 	}
	// })

	var i = 0;
	$('form').request('onChildren',{
			success: function(data) {
					i = data.length;
					if (i != 0) {
						$('#NumChildren').val(i);
					}else {
						 i = 0;
						$('#NumChildren').val(i);
					}
			}
	});

	var j = 0;
	$('form').request('onBrethren',{
			success: function(data) {
					j = data.length;
					if (j != 0) {
						$('#NumBrethren').val(j);
					}else {
						 j = 0;
						$('#NumBrethren').val(j);
					}
			}
	});

	$('#insert_Brethren').on('click','#addbrethren',function(){
				$('form').request('onAddBrethren', {
						data: {TitleNameBrethren: $('#TitleNameBrethren').val(),
									 NameBrethren: $('#NameBrethren').val(),
								   LastNameBrethren: $('#LastNameBrethren').val(),
							     BrethrenStatus: $('#BrethrenStatus').val(),
						       AgeBrethren: $('#AgeBrethren').val(),
					         OccupationBrethren: $('#OccupationBrethren').val(),},
						success: function(data) {
									 $(".bbb").remove();
									 $('form').request('onBrethren',{
										 success: function(dataBre) {
											 $(".bbbh:first").removeClass('hidden');
											 $(".bbbh").not(':first').remove();
											 $('#NumBrethren').val(dataBre.length);
											for (var i = 0; i < dataBre.length; i++) {
													var $tableBody = $('#data-b').find("tbody"),
									        $trLast = $tableBody.find("tr:last"),
									        $trNew = $trLast.clone();
									    		$trLast.after($trNew);

												$(".idFami-b:last").val(dataBre[i].idFamilies);
												$(".pfFirstName-b:last").html(dataBre[i].nameprefix+dataBre[i].FirstName_TH);
												$(".LastName-b:last").html(dataBre[i].LastName_TH);
												$(".life-b:last").html(dataBre[i].namelife);
												$(".Age-b:last").html(dataBre[i].Age);
												if (dataBre[i].idOccupation == null) {
													 $(".occupation-b:last").html('');
												}else {
													 $(".occupation-b:last").html(dataBre[i].nameoccupation);
												}
											}
											$(".bbbh:first").addClass('hidden');
	 									 $('#moDalAddBrethren').modal('hide');
										 }
									 })
										// swal({
		            		// 		title: "เพิ่มพี่น้องสำเร็จ!",
		            		// 		type: "success"
		        				// 	}, function() {
										// 			$('#moDalAddBrethren').modal('hide');
		            		// 			location.reload();
		        				// 	});
						}
				});
	}).on("change",".BrethrenStatus",function(){
			if(this.value=="2"){
				$('#AgeBrethren').prop('disabled',true);
				$('#OccupationBrethren').prop('disabled',true);
			}else{
				$('#AgeBrethren').prop('disabled',false);
				$('#OccupationBrethren').prop('disabled',false);
			}
		})

	$('form').on('click','.editBrethren',function(){
		 var edit = this.value;
		 $("#idFamiliesBrethren_edit").val(this.value);
		 // alert(this.value);
		 $('form').request('onBrethrenedit', {
			 data: {numedit: edit},
			 success: function(data) {
				 // alert(data.idFamilies);
				$("#TitleNameBrethren_edit").val(data.idPrefix).trigger("chosen:updated");
				$("#NameBrethren_edit").val(data.FirstName_TH);
				$("#LastNameBrethren_edit").val(data.LastName_TH);
				$("#BrethrenStatus_edit").val(data.idLife_Status).trigger("chosen:updated");
				if (data.idLife_Status == 2) {
					$("#AgeBrethren_edit").prop('disabled',true);
					$("#OccupationBrethren_edit").prop('disabled',true);
					$("#AgeBrethren_edit").val(data.Age);
					$("#OccupationBrethren_edit").val(data.idOccupation).trigger("chosen:updated");
				}else {
					$("#AgeBrethren_edit").prop('disabled',false);
					$("#OccupationBrethren_edit").prop('disabled',false);
					$("#AgeBrethren_edit").val(data.Age);
					$("#OccupationBrethren_edit").val(data.idOccupation).trigger("chosen:updated");
				}
			 }
		})
	}).on("change","#BrethrenStatus_edit",function(){
		// console.log(this.value);
			if(this.value=="2"){
				$('#AgeBrethren_edit').val('');
				$('#AgeBrethren_edit').prop('disabled',true);
				$('#OccupationBrethren_edit').val('').trigger("chosen:updated");
				$('#OccupationBrethren_edit').prop('disabled',true);
			}else{
				$('#AgeBrethren_edit').prop('disabled',false);
				$('#OccupationBrethren_edit').prop('disabled',false);
			}
		}).on('click','#AddBrethren',function(){
		$("#TitleNameBrethren").val('').trigger("chosen:updated");
		$("#NameBrethren").val('');
		$("#LastNameBrethren").val('');
		$("#BrethrenStatus").val('').trigger("chosen:updated");
		$("#AgeBrethren").val('');
		$("#OccupationBrethren").val('').trigger("chosen:updated");
	})

	$('#edit_Brethren').on('click','#upbrethren',function(){
		// alert($('#idFamiliesBrethren_edit').val());
		$('form').request('onUpdateBrethren', {
				data: {idFamiliesBrethren: $('#idFamiliesBrethren_edit').val(),
							 TitleNameBrethren: $('#TitleNameBrethren_edit').val(),
							 NameBrethren: $('#NameBrethren_edit').val(),
							 LastNameBrethren: $('#LastNameBrethren_edit').val(),
							 BrethrenStatus: $('#BrethrenStatus_edit').val(),
							 AgeBrethren: $('#AgeBrethren_edit').val(),
							 OccupationBrethren: $('#OccupationBrethren_edit').val(),},
				success: function(data) {
							$(".bbb").remove();
							$('form').request('onBrethren',{
								success: function(dataBre) {
									$(".bbbh:first").removeClass('hidden');
									$(".bbbh").not(':first').remove();
									$('#NumBrethren').val(dataBre.length);
								 for (var i = 0; i < dataBre.length; i++) {
										 var $tableBody = $('#data-b').find("tbody"),
										 $trLast = $tableBody.find("tr:last"),
										 $trNew = $trLast.clone();
										 $trLast.after($trNew);
									 $(".idFami-b:last").val(dataBre[i].idFamilies);
									 $(".pfFirstName-b:last").html(dataBre[i].nameprefix+dataBre[i].FirstName_TH);
									 $(".LastName-b:last").html(dataBre[i].LastName_TH);
									 $(".life-b:last").html(dataBre[i].namelife);
									 $(".Age-b:last").html(dataBre[i].Age);
									 if (dataBre[i].idOccupation == null) {
											$(".occupation-b:last").html('');
									 }else {
											$(".occupation-b:last").html(dataBre[i].nameoccupation);
									 }
								 }
								 $(".bbbh:first").addClass('hidden');
								$('#moDaleditBrethren').modal('hide');
								// $('#idFamiliesBrethren_edit').val('')
								}
							})
								// swal({
								 // 	 title: "แก้ไขสำเร็จ!",
								 // 	 type: "success"
								 //  }, function() {
								 // 		 $('#moDaleditBrethren').modal('hide');
								 // 		 location.reload();
								 // 	 });
					}
			});
	 }).on('click','#delbrethren',function(){
		swal({
				title: "คุณแน่ใจที่จะลบ ?",
				type: "warning",
				showCancelButton: true,
				cancelButtonText: "ไม่, ยังก่อน!",
				confirmButtonColor: "#DD6B55",
				confirmButtonText: "ใช่, ลบเลย!",
				closeOnConfirm: false
		}, function () {
				$('form').request('onDelBrethren', {
					data: {idFamiliesBrethren: $('#idFamiliesBrethren_edit').val()},
					success: function(data) {
						$(".bbb").remove();
						$('form').request('onBrethren',{
							success: function(dataBre) {
								$(".bbbh:first").removeClass('hidden');
								$(".bbbh").not(':first').remove();
								$('#NumBrethren').val(dataBre.length);
							 for (var i = 0; i < dataBre.length; i++) {
									 var $tableBody = $('#data-b').find("tbody"),
									 $trLast = $tableBody.find("tr:last"),
									 $trNew = $trLast.clone();
									 $trLast.after($trNew);
								 $(".idFami-b:last").val(dataBre[i].idFamilies);
								 $(".pfFirstName-b:last").html(dataBre[i].nameprefix+dataBre[i].FirstName_TH);
								 $(".LastName-b:last").html(dataBre[i].LastName_TH);
								 $(".life-b:last").html(dataBre[i].namelife);
								 $(".Age-b:last").html(dataBre[i].Age);
								 if (dataBre[i].idOccupation == null) {
										$(".occupation-b:last").html('');
								 }else {
										$(".occupation-b:last").html(dataBre[i].nameoccupation);
								 }
							 }
							 $(".bbbh:first").addClass('hidden');
							$('#moDaleditBrethren').modal('hide');
							// $('#idFamiliesBrethren_edit').val('')
							swal({
									title: "ลบสำเร็จ!",
									type: "success",
							},function () {
								// location.reload();
							})
							}
						})

					}
				})
		})
	})


1


	$('form').on('click','.editChildren',function(){
		 var edit = this.value;
		 $("#idFamiliesChildren_edit").val(this.value);
		 // alert(this.value);
		 $('form').request('onChildrenedit', {
			 data: {numedit: edit},
			 success: function(data) {
				$("#TitleNameChildren_edit").val(data.idPrefix).trigger("chosen:updated");
				$("#NameChildren_edit").val(data.FirstName_TH);
				$("#LastNameChildren_edit").val(data.LastName_TH);
				$("#AgeChildren_edit").val(data.Age);
			 }
			 })

	}).on('click','#AddChildren',function(){
		$("#TitleNameChildren").val('').trigger("chosen:updated");
		$("#NameChildren").val('');
		$("#LastNameChildren").val('');
		$("#AgeChildren").val('');
	})

	$('#edit_Children').on('click','#upChildren',function(){
		$('form').request('onUpdateChildren', {
				data: {idFamiliesChildren: $('#idFamiliesChildren_edit').val(),
							 TitleNameChildren: $('#TitleNameChildren_edit').val(),
							 NameChildren: $('#NameChildren_edit').val(),
							 LastNameChildren: $('#LastNameChildren_edit').val(),
							 AgeChildren: $('#AgeChildren_edit').val(),},
				success: function(data) {
					$(".ccc").remove();
					$('form').request('onChildren',{
						success: function(dataChil) {
							$(".ccch:first").removeClass('hidden');
							$(".ccch").not(':first').remove();
							$('#NumChildren').val(dataChil.length);
						 for (var i = 0; i < dataChil.length; i++) {
								 var $tableBody = $('#data-c').find("tbody"),
								 $trLast = $tableBody.find("tr:last"),
								 $trNew = $trLast.clone();
								 $trLast.after($trNew);
							 $(".idFami-c:last").val(dataChil[i].idFamilies);
							 $(".pfFirstName-c:last").html(dataChil[i].nameprefix+dataChil[i].FirstName_TH);
							 $(".LastName-c:last").html(dataChil[i].LastName_TH);
							 $(".Age-c:last").html(dataChil[i].Age);
						 }
						 $(".ccch:first").addClass('hidden');
						$('#moDaleditChildren').modal('hide');
						}
					})
								// swal({
								// 		title: "แก้ไขสำเร็จ!",
								// 		type: "success"
								// 	}, function() {
								// 			$('#moDaleditChildren').modal('hide');
								// 			location.reload();
								// 		});
				}
		});
 }).on('click','#delChildren',function(){
	 swal({
			 title: "คุณแน่ใจที่จะลบ ?",
			 type: "warning",
			 showCancelButton: true,
			 cancelButtonText: "ไม่, ยังก่อน!",
			 confirmButtonColor: "#DD6B55",
			 confirmButtonText: "ใช่, ลบเลย!",
			 closeOnConfirm: false
	 }, function () {
			 $('form').request('onDelChildren', {
				 data: {idFamiliesChildren: $('#idFamiliesChildren_edit').val(),},
				 success: function(data) {
					 $(".ccc").remove();
 					$('form').request('onChildren',{
 						success: function(dataChil) {
 							$(".ccch:first").removeClass('hidden');
 							$(".ccch").not(':first').remove();
 							$('#NumChildren').val(dataChil.length);
 						 for (var i = 0; i < dataChil.length; i++) {
 								 var $tableBody = $('#data-c').find("tbody"),
 								 $trLast = $tableBody.find("tr:last"),
 								 $trNew = $trLast.clone();
 								 $trLast.after($trNew);
 							 $(".idFami-c:last").val(dataChil[i].idFamilies);
 							 $(".pfFirstName-c:last").html(dataChil[i].nameprefix+dataChil[i].FirstName_TH);
 							 $(".LastName-c:last").html(dataChil[i].LastName_TH);
 							 $(".Age-c:last").html(dataChil[i].Age);
 						 }
 						 $(".ccch:first").addClass('hidden');
 						$('#moDaleditChildren').modal('hide');
 						}
 					})
					 swal({
							 title: "ลบสำเร็จ!",
							 type: "success",
					 },function () {
						 // $('#moDaleditChildren').modal('hide');
						 // location.reload();
					 })
				 }
				 })
	 })
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

		$('form').request('onStatusCandidate',{
				success: function(data) {
						// console.log(data.idMarital_Status);
						if (data.idMarital_Status != 1) {
								$('.boxMarital').removeClass('hidden');
						}
						if (data.idMarital_Status == null) {
								$('.boxMarital').addClass('hidden');
						}
				}
		});




});
