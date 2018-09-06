$(document).ready(function(){
	$('#boxend_Year').addClass('hidden');
	$('select.chosen').chosen({
        width: "100%",
        search_contains: true
    });
	$("body").on('click','#btnAddFormUndergradDegree',function(){
		// $("#boxUndergradDegree").append('<hr>');
		// $("#boxUndergradDegree").find('.row:first-child').clone().appendTo("#boxUndergradDegree");
	}).on('click','#btnAddFormUpDegree',function(){
		// $("#boxUpDegree").append('<hr>');
		// $("#boxUpDegree").find('.row:first-child').clone().appendTo("#boxUpDegree");
	}).on("change","#idGeography",function(){
         $.request('onGetInstituteDetail', {
            data: {idGeography: this.value,type_of_institue: $('#type_of_institue').val()},
            success: function(data) {
                $('#idInstitute_Detail').children('option:not(:first)').remove();
                $.each(data, function(k, v) {
                    $('#idInstitute_Detail').append($('<option>', {
                        value: v.id,
                        text: v.Name_TH
                    }));
                });
                if(data.length > 0){
                    $('.Faculty_Detail').addClass('hidden');
                    $('.Department').addClass('hidden');
                    $('#idDepartment').val('');
                    $('.Major_Subject').addClass('hidden');
                    $('#idMajor_Subject').val('');
                }else{
                    $('.Faculty_Detail').addClass('hidden');
                    $('#idFaculty_Detail').val('');
                    $('.Department').addClass('hidden');
                    $('#idDepartment').val('');
                    $('.Major_Subject').addClass('hidden');
                    $('#idMajor_Subject').val('');
                }
                $('select.chosen').trigger("chosen:updated");
            }
         });
    }).on("change","#type_of_institue",function(){
        $.request('onGetInstituteDetail', {
            data: {type_of_institue: this.value,idGeography: $('#idGeography').val()},
            success: function(data) {
                $('#idInstitute_Detail').children('option:not(:first)').remove();
                $.each(data, function(k, v) {
                    $('#idInstitute_Detail').append($('<option>', {
                        value: v.id,
                        text: v.Name_TH
                    }));
                });
                if(data.length > 0){
                    $('.Faculty_Detail').addClass('hidden');
                    $('.Department').addClass('hidden');
                    $('#idDepartment').val('');
                    $('.Major_Subject').addClass('hidden');
                    $('#idMajor_Subject').val('');
                    $('#idDegree_and_Certificate').val('');
                    $('#GPA').val('');
                }else{
                    $('.Faculty_Detail').addClass('hidden');
                    $('#idFaculty_Detail').val('');
                    $('.Department').addClass('hidden');
                    $('#idDepartment').val('');
                    $('.Major_Subject').addClass('hidden');
                    $('#idMajor_Subject').val('');
                }
                $('select.chosen').trigger("chosen:updated");
            }
        });
    }).on("change","#idInstitute_Detail",function(){
        $.request('onGetFaculty', {
            data: {value: this.value},
             success: function(data) {
                $('#idFaculty_Detail').children('option:not(:first)').remove();
                $.each(data, function(k, v) {
                    $('#idFaculty_Detail').append($('<option>', {
                        value: v.id,
                        text: v.Name_TH
                    }));
                });
                //$("#type_of_institue").val(data[0].idType_of_Institute);
                if(data.length > 0){
                    $('.Faculty_Detail').removeClass('hidden');
                    $('.Department').addClass('hidden');
                    $('#idDepartment').val('');
                    $('.Major_Subject').addClass('hidden');
                    $('#idMajor_Subject').val('');
                }else{
                    $('.Faculty_Detail').addClass('hidden');
                    $('#idFaculty_Detail').val('');
                    $('.Department').addClass('hidden');
                    $('#idDepartment').val('');
                    $('.Major_Subject').addClass('hidden');
                    $('#idMajor_Subject').val('');
                }
                $('select.chosen').trigger("chosen:updated");
            }
        });
        $.request('onGetTypeOfInstitue', {
            data: {value: this.value},
            success: function(data) {
                $("#type_of_institue").val(data.idType_of_Institute);
                $('select.chosen').trigger("chosen:updated");
            }
        });
    }).on('change','#idEducation_Level',function(){
        if(this.value ==""){
            $('#boxidGeography,#boxtype_of_institue,#boxidInstitute_Detail,#boxidFaculty_Detail,#boxidDepartment,#boxidMajor_Subject,#boxidDegree_and_Certificate,#boxGPA,#boxidEducation_Status,#boxYear').addClass('hidden');
        }else if(this.value=="1"){
            $('#boxidGeography,#boxtype_of_institue,#boxidInstitute_Detail,#boxidFaculty_Detail,#boxidDepartment,#boxidMajor_Subject').addClass('hidden');
            $('#boxidDegree_and_Certificate,#boxGPA,#boxidEducation_Status,#boxYear').removeClass('hidden');
        }else{
            $('#boxidGeography,#boxtype_of_institue,#boxidInstitute_Detail,#boxidEducation_Status,#boxYear').removeClass('hidden');
            $('#boxidDegree_and_Certificate,#boxGPA').removeClass('hidden');
            $('#boxidFaculty_Detail,#boxidDepartment,#boxidMajor_Subject').addClass('hidden');
            $('#idGeography,#type_of_institue,#idInstitute_Detail,#idDegree_and_Certificate,#GPA').val('');
            $('select.chosen').trigger("chosen:updated");
        }
        $.request('onGetDegreeAndCertificate', {
            data: {value: this.value},
                success: function(data) {
                    $('#idDegree_and_Certificate').children('option:not(:first)').remove();
                    $.each(data, function(k, v) {
                        $('#idDegree_and_Certificate').append($('<option>', {
                            value: v.id,
                            text: v.Name_TH
                        }));
                    });
                    $('select.chosen').trigger("chosen:updated");
                }
            });
    }).on('change','#idFaculty_Detail',function(){
        $.request('onGetDepartment', {
            data: {value: this.value},
            success: function(data) {
                $('#idDepartment').children('option:not(:first)').remove();
                $.each(data, function(k, v) {
                    $('#idDepartment').append($('<option>', {
                        value: v.id,
                        text: v.Name_TH
                    }));
                });
                if(data.length > 0){
                    $('.Department').removeClass('hidden');
                    $('.Major_Subject').addClass('hidden');
                    $('#idMajor_Subject').val('');
                }else{
                    $('.Department').addClass('hidden');
                    $('#idDepartment').val('');
                    $('.Major_Subject').addClass('hidden');
                    $('#idMajor_Subject').val('');
                }
                $('select.chosen').trigger("chosen:updated");
            }
        });
    }).on('change','#idDepartment',function(){
        $.request('onGetMajor', {
            data: {value: this.value},
            success: function(data) {
                $('#idMajor_Subject').children('option:not(:first)').remove();
                $.each(data, function(k, v) {
                    $('#idMajor_Subject').append($('<option>', {
                        value: v.id,
                        text: v.Name_TH
                    }));
                });
                if(data.length > 0){
                    $('.Major_Subject').removeClass('hidden');
                }else{
                    $('.Major_Subject').addClass('hidden');
                    $('#idMajor_Subject').val('');
                }
                $('select.chosen').trigger("chosen:updated");
            }
        });
    }).on('change','#idEducation_Status',function(){
			if (this.value != 2) {
				$('#boxend_Year').addClass('hidden');
			} else {
				$('#boxend_Year').removeClass('hidden');
			}
		})

		$('#idGeography').each(function(){
				$.request('onGetInstituteDetail', {
						data: {idGeography: this.value,type_of_institue: $('#type_of_institue').val()},
						success: function(data) {
								$('#idInstitute_Detail').children('option:not(:first)').remove();
								$.each(data, function(k, v) {
										$('#idInstitute_Detail').append($('<option>', {
												value: v.id,
												text: v.Name_TH
										}));
								});
								$("#idInstitute_Detail").val($("#tempidInstitute_Detail").val());
								$('select.chosen').trigger("chosen:updated");
						}
				 });
		});
		$('#tempidInstitute_Detail').each(function(){
				if(this.value!=""){
						$.request('onGetFaculty', {
								data: {value: this.value},
								 success: function(data) {
										$('#idFaculty_Detail').children('option:not(:first)').remove();
										$.each(data, function(k, v) {
												$('#idFaculty_Detail').append($('<option>', {
														value: v.id,
														text: v.Name_TH
												}));
										});
										$("#idFaculty_Detail").val($("#tempidFaculty_Detail").val());
										if(data.length > 0){
												$('.Faculty_Detail').removeClass('hidden');
										}else{
												$('.Faculty_Detail').addClass('hidden');
										}
										$('select.chosen').trigger("chosen:updated");
								}
						});
				}
		});

		$("#tempidFaculty_Detail").each(function(){
				$.request('onGetDepartment', {
						data: {value: this.value},
						success: function(data) {
								$('#idDepartment').children('option:not(:first)').remove();
								$.each(data, function(k, v) {
										$('#idDepartment').append($('<option>', {
												value: v.id,
												text: v.Name_TH
										}));
								});
								$("#idDepartment").val($("#tempidDepartment").val());
								if(data.length > 0){
										$('.Department').removeClass('hidden');
								}else{
										$('.Department').addClass('hidden');
								}
								$('select.chosen').trigger("chosen:updated");
						}
				});
		});

		$("input:radio[name='Setting_Edu_CV']").on('click',function(){
			// alert($('.Setting_Edu_CV').val());
			var set = $("input:radio[name='Setting_Edu_CV']:checked").val();
			// console.log(set);
			$("input:radio[name='Setting_Edu_CV_Mo']").val([set]);
			$.request('onSetting_Edu', {
					data: {idEdu: set},
					success: function(data) {
						// for (var i = 0; i < data.length; i++) {
						// 	console.log(data[i].GPA);
						// }
					}
			});

			});

		$("input:radio[name='Setting_Edu_CV_Mo']").on('click',function(){
				// alert($('.Setting_Edu_CV').val());

			var setMo = $("input:radio[name='Setting_Edu_CV_Mo']:checked").val()
			// console.log(setMo);
			$("input:radio[name='Setting_Edu_CV']").val([setMo]);
			$.request('onSetting_Edu', {
					data: {idEdu: setMo},
					success: function(data) {
						// for (var i = 0; i < data.length; i++) {
						// 	console.log(data[i].GPA);
						// }
					}
			});


			});


		$("#tempidDepartment").each(function(){
				$.request('onGetMajor', {
						data: {value: this.value},
						success: function(data) {
								$('#idMajor_Subject').children('option:not(:first)').remove();
								$.each(data, function(k, v) {
										$('#idMajor_Subject').append($('<option>', {
												value: v.id,
												text: v.Name_TH
										}));
								});
								$("#idMajor_Subject").val($("#tempidMajor_Subject").val());
								if(data.length > 0){
										$('.Major_Subject').removeClass('hidden');
								}else{
										$('.Major_Subject').addClass('hidden');
								}
								$('select.chosen').trigger("chosen:updated");
						}
				});
		});

		$("#tempidEducation_Level").each(function(){
				$.request('onGetDegreeAndCertificate', {
						data: {value: this.value},
						success: function(data) {
								$('#idDegree_and_Certificate').children('option:not(:first)').remove();
								$.each(data, function(k, v) {
										$('#idDegree_and_Certificate').append($('<option>', {
												value: v.id,
												text: v.Name_TH
										}));
								});
								$("#idDegree_and_Certificate").val($("#tempidDegree_and_Certificate").val());
								$('select.chosen').trigger("chosen:updated");
						}
				});
		});


		$('#start_Year').each(function(){
			var start = new Date().getFullYear()+543-30;
			var end = new Date().getFullYear()+543;
			select = document.getElementById( 'start_Year' );
				for ( i = start; i <= end; i ++ ) {
						option = document.createElement('option');
						option.value = option.text = i;
						select.add( option );
			}
		})

		$('#end_Year').each(function(){
			var start = new Date().getFullYear()+543-30;
			var end = new Date().getFullYear()+543;
			select = document.getElementById( 'end_Year' );
				for ( i = start; i <= end; i ++ ) {
				    option = document.createElement('option');
				    option.value = option.text = i;
				    select.add( option );
			}
		})
		//เพิ่มการศึกษา
		$('#insert_Education').on('click','#addEducation',function(){
				$(".ddd").remove();
				$(".mmm").remove();
				$(".dddh:first").removeClass('hidden');
				$(".mmmh:first").removeClass('hidden');

				$(".dddUP").remove();
				$(".mmmUP").remove();
				$(".dddhUP:first").removeClass('hidden');
				$(".mmmhUP:first").removeClass('hidden');

				$.request('onEducation',{
				        success: function(data) {
									$(".dddh:first").removeClass('hidden');
									$(".mmmh:first").removeClass('hidden');
				          $(".dddh").not(':first').remove();
									$(".mmmh").not(':first').remove();

									$(".dddhUP:first").removeClass('hidden');
									$(".mmmhUP:first").removeClass('hidden');
				          $(".dddhUP").not(':first').remove();
									$(".mmmhUP").not(':first').remove();

				         for (var i = 0; i < data.length; i++) {
									 	// console.log(data[i].idEducation);
										if (data[i].idEducation_Level == 1) {
											// ตำกว่าปริญญาตรี
										 var $tableBody = $('#data-UnderDegree').find("tbody.data-dd"),
 				             $trLast = $tableBody.find("tr:last"),
 				             $trNew = $trLast.clone();
 				             $trLast.after($trNew);

										 //radio
										 $(".nameeducation_level-under:last").html(data[i].nameeducation_level);
										 $(".namedegree-under:last").html(data[i].namedegree);
										 $("span.spanlo-under:last").remove();
										 $("h3.lod-under:last").remove();
										 if (data[i].Year_of_Admission == 0) {
											$("div.lod-under:last").append("<span class='loading bullet spanlo-under'></span>");
										 }else {
											 if (data[i].Year_of_Graduation == 0) {
  											$("div.lod-under:last").after("<h3 class='lod-under'>"+data[i].Year_of_Admission+"-ปัจจุบัน</h3>");
  										 }else {
  											 $("div.lod-under:last").after("<h3>"+data[i].Year_of_Admission+"-"+data[i].Year_of_Graduation+"</h3>");
  										 }
										 }
										 $(".GPA-under:last").html(data[i].GPA);
										 $(".editEndu-under:last").val(data[i].idEducation);

 										 var $tableBody_M = $('#data-UnderDegree').find("tbody.data-mm"),
 				             $trLast_M = $tableBody_M.find("tr:last"),
 				             $trNew_M = $trLast_M.clone();
 				             $trLast_M.after($trNew_M);

										 //radio
										 $(".nameeducation_level-under-mo:last").html(data[i].nameeducation_level);
										 $(".namedegree-under-mo:last").html(data[i].namedegree);
										 $("span.spanlo-under-mo:last").remove();
										 $("h5.lod-under-mo:last").remove();
										 if (data[i].Year_of_Admission == 0) {
											$("div.lod-under-mo:last").append("<span class='loading bullet spanlo-under-mo'></span>");
										 }else {
											 if (data[i].Year_of_Graduation == 0) {
  											$("div.lod-under-mo:last").after("<h5 class='lod-under-mo' style='display: inline-block;'>"+data[i].Year_of_Admission+"-ปัจจุบัน</h5>");
  										 }else {
  											 $("div.lod-under-mo:last").after("<h5 style='display: inline-block;'>"+data[i].Year_of_Admission+"-"+data[i].Year_of_Graduation+"</h5>");
  										 }
										 }
										 $(".GPA-under-mo:last").html(data[i].GPA);
										 $(".editEndu-under-mo:last").val(data[i].idEducation);

									 }else {
										 // ปริญญาตรีขึ้นไป

											var $tableBody_UP = $('#data-UpDegree').find("tbody.data-dddUP"),
  				             $trLast_UP = $tableBody_UP.find("tr:last"),
  				             $trNew_UP = $trLast_UP.clone();
  				             $trLast_UP.after($trNew_UP);
											 $(".spanlo-Up:last").addClass('hidden');

											 //Radio
											 $(".nameinstitute-Up:last").html(data[i].nameinstitute);
											 $(".namedegree-Up:last").html(data[i].namedegree);
											 if (data[i].namedepartment != null) {
												 $(".deparfacu:last").html('ภาควิชา/สาขาวิชา');
												 $(".namedeparfacu:last").html(data[i].namedepartment);
											 }else {
												 $(".deparfacu:last").html('คณะ');
												 $(".namedeparfacu:last").html(data[i].namefaculty);
											 }
											 // $("span.spanlo-Up:first").remove();
											 $("h3.lod-Up:last").remove();
											 console.log(data[i].Year_of_Admission);
											 if (data[i].Year_of_Admission == 0) {
												// $("div.lod-Up:last").append("<span class='loading bullet spanlo-Up'></span>");
													$(".spanlo-Up:last").removeClass('hidden');
											 }else {
												 if (data[i].Year_of_Graduation == 0) {
	  											$("div.lod-Up:last").after("<h3 class='lod-Up'>"+data[i].Year_of_Admission+"-ปัจจุบัน</h3>");
	  										 }else {
	  											 $("div.lod-Up:last").after("<h3 class='lod-Up'>"+data[i].Year_of_Admission+"-"+data[i].Year_of_Graduation+"</h3>");
	  										 }
											 }
											 $(".GPA-Up:last").html(data[i].GPA);
											 $(".editEndu-Up:last").val(data[i].idEducation);

  										 var $tableBody_M_UP = $('#data-UpDegree').find("tbody.data-mmmUP"),
  				             $trLast_M_UP = $tableBody_M_UP.find("tr:last"),
  				             $trNew_M_UP = $trLast_M_UP.clone();
  				             $trLast_M_UP.after($trNew_M_UP);
											 $(".spanlo-Up-Mo:last").addClass('hidden');

											 //Radio
											 $(".nameinstitute-Up-Mo:last").html(data[i].nameinstitute);
											 $(".namedegree-Up-Mo:last").html(data[i].namedegree);
											 if (data[i].namedepartment != null) {
												 // $(".deparfacu-Mo:last").html('ภาควิชา/สาขาวิชา');
												 $(".namedeparfacu-Mo:last").html(data[i].namedepartment);
											 }else {
												 // $(".deparfacu-Mo:last").html('คณะ');
												 $(".namedeparfacu-Mo:last").html(data[i].namefaculty);
											 }
											 $("h5.lod-Up-Mo:last").remove();
											 console.log(data[i].Year_of_Admission);
											 if (data[i].Year_of_Admission == 0) {
													$(".spanlo-Up-Mo:last").removeClass('hidden');
											 }else {
												 if (data[i].Year_of_Graduation == 0) {
	  											$("div.lod-Up-Mo:last").after("<h5 class='lod-Up-Mo' style='display: inline-block;'>"+data[i].Year_of_Admission+"-ปัจจุบัน</h5>");
	  										 }else {
	  											 $("div.lod-Up-Mo:last").after("<h5 class='lod-Up-Mo' style='display: inline-block;'>"+data[i].Year_of_Admission+"-"+data[i].Year_of_Graduation+"</h5>");
	  										 }
											 }
											 $(".GPA-Up-Mo:last").html(data[i].GPA);
											 $(".editEndu-Up-Mo:last").val(data[i].idEducation);

										}
				         }
				         $(".dddh:first").addClass('hidden');
								 $(".mmmh:first").addClass('hidden');

								 $(".dddhUP:first").addClass('hidden');
								 $(".mmmhUP:first").addClass('hidden');

				        $('#moDalAddEducation').modal('hide');
				        }
				      })

					// $('form').request('onAddEducation', {
					//     data: {idEducation_Level: $('#idEducation_Level').val(),
					//            idGeography: $('#idGeography').val(),
					//            type_of_institue: $('#type_of_institue').val(),
					//            idInstitute_Detail: $('#idInstitute_Detail').val(),
					//            idFaculty_Detail: $('#idFaculty_Detail').val(),
					//            idDepartment: $('#idDepartment').val(),
					//            idMajor_Subject: $('#idMajor_Subject').val(),
					//            idEducation_Status: $('#idEducation_Status').val(),
					//            start_Year: $('#start_Year').val(),
					//            end_Year: $('#end_Year').val(),
					//            idDegree_and_Certificate: $('#idDegree_and_Certificate').val(),
					//            GPA_Education: $('#GPA').val()},
					//     success: function(data) {
					// 			console.log(data);
					//       // $(".ccc").remove();
					//       // $('form').request('onChildren',{
					//       //   success: function(dataChil) {
					//       //   //   $(".ccch:first").removeClass('hidden');
					//       //   //   $(".ccch").not(':first').remove();
					//       //   //   $('#NumChildren').val(dataChil.length);
					//       //   //  for (var i = 0; i < dataChil.length; i++) {
					//       //   //      var $tableBody = $('#data-c').find("tbody"),
					//       //   //      $trLast = $tableBody.find("tr:last"),
					//       //   //      $trNew = $trLast.clone();
					//       //   //      $trLast.after($trNew);
					//       //   //
					//       //   //    $(".idFami-c:last").val(dataChil[i].idFamilies);
					//       //   //    $(".pfFirstName-c:last").html(dataChil[i].nameprefix+dataChil[i].FirstName_TH);
					//       //   //    $(".LastName-c:last").html(dataChil[i].LastName_TH);
					//       //   //    $(".Age-c:last").html(dataChil[i].Age);
					//       //   //  }
					//       //   //  $(".ccch:first").addClass('hidden');
					//         $('#moDalAddEducation').modal('hide');
					//       //   }
					//       // })
					//     }
					// });
		})

		$('#AddEducation_Undergrad').on('click',function(){
					$('#boxidGeography,#boxtype_of_institue,#boxidInstitute_Detail,#boxidFaculty_Detail,#boxidDepartment,#boxidMajor_Subject').addClass('hidden');
					$('#boxidDegree_and_Certificate,#boxGPA,#boxidEducation_Status,#boxYear').removeClass('hidden');
					$('#idGeography,#type_of_institue,#idInstitute_Detail,#idDegree_and_Certificate,#GPA','#idEducation_Status','#start_Year','#end_Year').val('');
					$('select.chosen').trigger("chosen:updated")
					$.request('onGetEducationLevel', {
									success: function(data) {
										// console.log(data);
										var www ;
											$('#idEducation_Level').children('option').remove();
											$.each(data, function(k, v) {
												if (v.idEducation_Level == 1) {
													www = v.idEducation_Level;
													$('#idEducation_Level').append($('<option>', {
															value: v.idEducation_Level,
															text: v.Name_TH
													}));
													$('select.chosen').trigger("chosen:updated");
												}
											});
											// console.log(www);
											$.request('onGetDegreeAndCertificate', {
													data: {value: www},
															success: function(data) {
																	$('#idDegree_and_Certificate').children('option:not(:first)').remove();
																	$.each(data, function(k, v) {
																			$('#idDegree_and_Certificate').append($('<option>', {
																					value: v.id,
																					text: v.Name_TH
																			}));
																	});
																	$('select.chosen').trigger("chosen:updated");
															}
													});
									}
							});
		})

		$('#AddEducation_UpDegree').on('click',function(){
				$('#boxidGeography,#boxtype_of_institue,#boxidInstitute_Detail,#boxidEducation_Status,#boxYear').removeClass('hidden');
				$('#boxidDegree_and_Certificate,#boxGPA').removeClass('hidden');
				$('#boxidFaculty_Detail,#boxidDepartment,#boxidMajor_Subject').addClass('hidden');
				$('#idGeography,#type_of_institue,#idInstitute_Detail,#idDegree_and_Certificate,#GPA','#idEducation_Status','#start_Year','#end_Year').val('');
				$('select.chosen').trigger("chosen:updated");
					$.request('onGetEducationLevel', {
									success: function(data) {
										// console.log(data);
										var www = 2;
											$('#idEducation_Level').children('option').remove();
											$.each(data, function(k, v) {
												if (v.idEducation_Level != 1) {
													// www = v.idEducation_Level;
													$('#idEducation_Level').append($('<option>', {
															value: v.idEducation_Level,
															text: v.Name_TH
													}));
													$('select.chosen').trigger("chosen:updated");
												}
											});
											console.log(www);
											$.request('onGetDegreeAndCertificate', {
													data: {value: www},
															success: function(data) {
																	$('#idDegree_and_Certificate').children('option:not(:first)').remove();
																	$.each(data, function(k, v) {
																			$('#idDegree_and_Certificate').append($('<option>', {
																					value: v.id,
																					text: v.Name_TH
																			}));
																	});
																	$('select.chosen').trigger("chosen:updated");
															}
													});


									}
							});
		})



});
