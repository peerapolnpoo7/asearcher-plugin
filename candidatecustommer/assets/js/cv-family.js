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
										swal({
		            				title: "เพิ่มพี่น้องสำเร็จ!",
		            				type: "success"
		        					}, function() {
													$('#moDalAddBrethren').modal('hide');
		            					location.reload();
		        					});
						}
				});
	})

	$('form').on('click','.editBrethren',function(){
		 var edit = this.value;
		 // alert(this.value);
		 $('form').request('onBrethrenedit', {
			 data: {numedit: edit},
			 success: function(data) {
				$("#TitleNameBrethren_edit").val(data.idPrefix).trigger("chosen:updated");
				$("#NameBrethren_edit").val(data.FirstName_TH);
				$("#LastNameBrethren_edit").val(data.LastName_TH);
				$("#BrethrenStatus_edit").val(data.idLife_Status).trigger("chosen:updated");
				$("#AgeBrethren_edit").val(data.Age);
				$("#OccupationBrethren_edit").val(data.idOccupation).trigger("chosen:updated");
			 }
			 })
		 $('#edit_Brethren').on('click','#upbrethren',function(){
			 $('form').request('onUpdateBrethren', {
					 data: {numedit: edit,
						 			TitleNameBrethren: $('#TitleNameBrethren_edit').val(),
									NameBrethren: $('#NameBrethren_edit').val(),
									LastNameBrethren: $('#LastNameBrethren_edit').val(),
									BrethrenStatus: $('#BrethrenStatus_edit').val(),
									AgeBrethren: $('#AgeBrethren_edit').val(),
									OccupationBrethren: $('#OccupationBrethren_edit').val(),},
					 success: function(data) {
									 swal({
											 title: "แก้ไขสำเร็จ!",
											 type: "success"
										 }, function() {
												 $('#moDaleditBrethren').modal('hide');
												 location.reload();
											 });
					 }
			 });
	 	}).on('click','#delbrethren',function(){
			// console.log(edit);
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
						data: {numedit: edit},
						success: function(data) {
							swal({
									title: "ลบสำเร็จ!",
									type: "success",
							},function () {
								$('#moDaleditBrethren').modal('hide');
								location.reload();
							})
						}
						})
			})
		})
	}).on('click','#AddBrethren',function(){
		$("#TitleNameBrethren option[value='']").attr("selected","selected").trigger("chosen:updated");
		$("#NameBrethren").val('');
		$("#LastNameBrethren").val('');
		$("#BrethrenStatus option[value='1']").attr("selected","selected").trigger("chosen:updated");
		$("#AgeBrethren").val('');
		$("#OccupationBrethren option[value='']").attr("selected","selected").trigger("chosen:updated");
	})



	$('#insert_Children').on('click','#addChildren',function(){
				$('form').request('onAddChildren', {
						data: {TitleNameChildren: $('#TitleNameChildren').val(),
									 NameChildren: $('#NameChildren').val(),
									 LastNameChildren: $('#LastNameChildren').val(),
									 AgeChildren: $('#AgeChildren').val(),},
						success: function(data) {
										swal({
												title: "เพิ่มบุตรสำเร็จ!",
												type: "success"
											}, function() {
													$('#moDalAddChildren').modal('hide');
													location.reload();
											});
						}
				});
	})

	$('form').on('click','.editChildren',function(){
		 var edit = this.value;
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
		 $('#edit_Children').on('click','#upChildren',function(){
			 $('form').request('onUpdateChildren', {
					 data: {numedit: edit,
									TitleNameChildren: $('#TitleNameChildren_edit').val(),
									NameChildren: $('#NameChildren_edit').val(),
									LastNameChildren: $('#LastNameChildren_edit').val(),
									AgeChildren: $('#AgeChildren_edit').val(),},
					 success: function(data) {
									 swal({
											 title: "แก้ไขสำเร็จ!",
											 type: "success"
										 }, function() {
												 $('#moDaleditChildren').modal('hide');
												 location.reload();
											 });
					 }
			 });
		}).on('click','#delChildren',function(){
			// console.log(edit);
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
						data: {numedit: edit},
						success: function(data) {
							swal({
									title: "ลบสำเร็จ!",
									type: "success",
							},function () {
								$('#moDaleditChildren').modal('hide');
								location.reload();
							})
						}
						})
			})
		})
	}).on('click','#AddChildren',function(){
		$("#TitleNameChildren option[value='']").attr("selected","selected").trigger("chosen:updated");
		$("#NameChildren").val('');
		$("#LastNameChildren").val('');
		$("#AgeChildren").val('');
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
				}
		});


});
