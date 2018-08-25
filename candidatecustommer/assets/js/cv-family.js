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

	// var j = 0;
	$('form').request('onBrethren',{
			success: function(data) {
	// 			$('#btnRemove_B').attr('disabled', true);
					// console.log(data.length);
					$('#NumBrethren').val(data.length);
	// 				j = data.length;
	// 				if (j != 0) {
	// 					$('#NumBrethren').val(j);
	//
	// 					for (var h = 1; h <= j; h++) {
	// 						if (h == 1) {
	// 								$("#boxBrethren").find('.row:first-child').removeClass('hidden');
	// 						}else if (h >= 2) {
	// 							$("#boxBrethren").find('.row:last-child' ).clone().appendTo("#boxBrethren");
	// 							$("#boxBrethren .row:last-child").find(".No").text(h);
	// 							$("#boxBrethren .row:last-child").find(".Brethren").each(function(){
	// 								var idExp=this.id.split("_");
	// 								$(this).attr('id',idExp[0]+'_'+h);
	// 							});
	// 						}
	// 						$("#TitleNameBrethren_"+h+" option[value='" + data[h-1].idPrefix +"']").attr("selected","selected");
	// 						$("#NameBrethren_"+h+"").val(data[h-1].FirstName_TH);
	// 						$("#LastNameBrethren_"+h+"").val(data[h-1].LastName_TH);
	// 						// $("#BrethrenStatus_"+h+"").val(data[h-1].idLife_Status);
	// 						$("#BrethrenStatus_"+h+" option[value='" + data[h-1].idLife_Status +"']").attr("selected","selected");
	// 						$("#AgeBrethren_"+h+"").val(data[h-1].Age);
	// 						// $("#OccupationBrethren_"+h+"").val(data[h-1].idOccupation);
	// 						$("#OccupationBrethren_"+h+" option[value='" + data[h-1].idOccupation +"']").attr("selected","selected");
	// 					}
	// 				}else {
	// 					 j = 0;
	// 					$('#NumBrethren').val(j);
	// 				}
	//
	// 				$("body").on('click','#btnAdd_B',function(){
	// 					j = j + 1;
	// 					if (j == 9) {
	// 						$('#btnAdd_B').attr('disabled', true);
	// 					}else {
	// 						$('#btnAdd_B').attr('disabled', false);
	// 					}
	//
	// 					if (j > data.length ) {
	// 								$('#btnRemove_B').removeClass('btn-danger');
	// 								$("#btnRemove_B").addClass('btn-white');
	// 								$('#btnRemove_B').attr('disabled', false);
	// 					}
	//
	// 					$('#NumBrethren').val(j);
	// 					$("#boxBrethren").find('.row:first-child').removeClass('hidden');
	// 					if (j >= 2) {
	// 						$("#boxBrethren").find('.row:last-child' ).clone().appendTo("#boxBrethren").val("");
	// 						$("#boxBrethren .row:last-child").find(".No").text(j);
	// 						$("#boxBrethren .row:last-child").find(".Brethren").val("").each(function(){
	// 							var idExp=this.id.split("_");
	// 							$(this).attr('id',idExp[0]+'_'+j);
	// 						});
	// 					}
	// 				// console.log(j);
	// 					$("#TitleNameBrethren_"+j+" option[value='']").attr("selected","selected");
	// 					$("#BrethrenStatus_"+j+" option[value='1']").attr("selected","selected").trigger("BrethrenStatus:updated");
	// 					$("#OccupationBrethren_"+j+" option[value='']").attr("selected","selected");
	// 				}).on('click','#btnRemove_B.btn-danger',function(){
	// 							var TitleName = $("#TitleNameBrethren_"+j+"").val();
	// 							var nameDel = $("#NameBrethren_"+j+"").val();
	// 							var lastnameDel = $("#LastNameBrethren_"+j+"").val();
	// 							console.log(TitleName);
	// 							console.log(nameDel);
	// 							console.log(lastnameDel);
	//
	// 							swal({
	// 	                title: "คุณแน่ใจที่จะลบ ?",
	// 	                text: ""+TitleName+""+nameDel+"  "+lastnameDel+" ออกจากพี่น้องใช่หรือไม่",
	// 	                type: "warning",
	// 	                showCancelButton: true,
	// 	                confirmButtonColor: "#DD6B55",
	// 	                confirmButtonText: "ใช่, ลบเลย!",
	// 	                closeOnConfirm: false
	// 	            }, function () {
	// 	                swal("ลบสำเร็จ!", "", "success");
	// 	            })
	//
	// 				}).on('click','#btnRemove_B.btn-white',function(){
	// 					if (j == 1 ) {
	// 						$("#boxBrethren").find('.row:first-child').addClass('hidden');
	// 					}else {
	// 						$("#boxBrethren .row:last-child").remove();
	// 					}
	// 					j = j - 1;
	// 					$('#NumBrethren').val(j);
	//
	// 					if (data.length != 0) {
	// 						if (data.length == j) {
	// 									// $('#btnRemove_B').attr('disabled', true);
	// 									$('#btnRemove_B').removeClass('btn-white');
	// 									$("#btnRemove_B").addClass('btn-danger');
	// 						}else {
	// 									$('#btnRemove_B').removeClass('btn-danger');
	// 									$("#btnRemove_B").addClass('btn-white');
	// 									// $('#btnRemove_B').attr('disabled', false);
	// 						}
	//
	// 						if (j != data.length) {
	// 									$('#btnAdd_B').attr('disabled', false);
	// 						}
	// 					} else {
	// 						if (j == 0) {
	// 									$('#btnRemove_B').attr('disabled', true);
	// 						}else {
	// 									$('#btnRemove_B').attr('disabled', false);
	// 						}
	//
	// 						if (j != 0) {
	// 									$('#btnAdd_B').attr('disabled', false);
	// 						}
	// 					}
	//
	// 				})
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
