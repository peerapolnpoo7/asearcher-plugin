function callComponent(callto,value,box,selected)
{
    $.request(callto, {
        data: {value: value},
        success: function(data) {
            $(box).children('option:not(:first)').remove();
            $.each(data, function(k, v) {
                $(box).append($('<option>', {
                    value: v.id,
                    text: v.Name_TH
                }));
            });
            if(selected!="0"){
                $(box).val(selected);
            }
            $('select.chosen').trigger("chosen:updated");
        }
    });
}

function getSeniority($type,$select)
{
    $.request("onGetSeniority", {
        data: {value: $type},
        success: function(data) {
            $("#Seniority").children('option:not(:first)').remove();
            $.each(data, function(k, v) {
                $("#Seniority").append($('<option>', {
                    value: v.id,
                    text: v.Name_TH
                }));
            });
            if($select!=""){
                $("#Seniority").val($select);
            }
            $('select.chosen').trigger("chosen:updated");
        }
    });
}
$(document).ready(function(){
	$('select.chosen').chosen({
        width: "100%",
        search_contains: true
    });
    $('.chosen-select').chosen({width: "100%",height:"100%"});
    $(".select2_demo_2").select2();
	$("#ionrangeListenLevel").ionRangeSlider({
                grid: true,
                from: $("input[name='ionrangeListenLevel']").val(),
                values: [
                "พอใช้", "ปานกลาง", "ดี",
                "ดีมาก"
                ],
                onChange: function (data) {
			          $('input[name="ionrangeListenLevel"]').val(data.from);
			    }
            });

	$("#ionrangeSpeakingLevel").ionRangeSlider({
                grid: true,
                from: $("input[name='ionrangeSpeakingLevel']").val(),
                values: [
                "พอใช้", "ปานกลาง", "ดี",
                "ดีมาก"
                ],
                onChange: function (data) {
			         $('input[name="ionrangeSpeakingLevel"]').val(data.from);
			    }
            });
	$("#ionrangeReadingLevel").ionRangeSlider({
                grid: true,
                from: $("input[name='ionrangeReadingLevel']").val(),
                values: [
                "พอใช้", "ปานกลาง", "ดี",
                "ดีมาก"
                ],
                onChange: function (data) {
			        $('input[name="ionrangeReadingLevel"]').val(data.from);
			    }
            });
	$("#ionrangeWritingLevel").ionRangeSlider({
                grid: true,
                from: $("input[name='ionrangeWritingLevel']").val(),
                values: [
                "พอใช้", "ปานกลาง", "ดี",
                "ดีมาก"
                ],
                onChange: function (data) {
			        $('input[name="ionrangeWritingLevel"]').val(data.from);
			    }
            });
    $("#ionrangeSkillListLevel").ionRangeSlider({
                grid: true,
                from: $("input[name='ionrangeSkillListLevel']").val(),
                values: [
                "เริ่มต้น", "ขั้นพื้นฐาน", "ปานกลาง", "ขั้นสูง", "ชำนาญ"
                ],
                onChange: function (data) {
			        $('input[name="ionrangeSkillListLevel"]').val(data.from);
			    }
    });
    $("#Word_Level").ionRangeSlider({
                grid: true,
                grid_snap:false,
                from: $("input[name='Word_Level']").val(),
                values: [
                "เริ่มต้น", "ขั้นพื้นฐาน", "ปานกลาง", "ขั้นสูง", "ชำนาญ"
                ],
                onChange: function (data) {
                    $('input[name="Word_Level"]').val(data.from);
                }
            });
    $("#Excel_Level").ionRangeSlider({
                grid: true,
                grid_snap:false,
                from: $("input[name='Excel_Level']").val(),
                values: [
                "เริ่มต้น", "ขั้นพื้นฐาน", "ปานกลาง", "ขั้นสูง", "ชำนาญ"
                ],
                onChange: function (data) {
                    $('input[name="Excel_Level"]').val(data.from);
                }
            });
    $("#Powerpoint_Level").ionRangeSlider({
                grid: true,
                grid_snap:false,
                from: $("input[name='Powerpoint_Level']").val(),
                values: [
                "เริ่มต้น", "ขั้นพื้นฐาน", "ปานกลาง", "ขั้นสูง", "ชำนาญ"
                ],
                onChange: function (data) {
                    $('input[name="Powerpoint_Level"]').val(data.from);
                }
            });
    $("#Typing_Thai_Level").ionRangeSlider({
                grid: true,
                grid_snap:false,
                from: $("input[name='Typing_Thai_Level']").val(),
                values: [
                "0-25", "25-50", "51-75", "76-100", "101-125,"
                ],
                onChange: function (data) {
                    $('input[name="Typing_Thai_Level"]').val(data.from);
                }
    });
    $("#Typing_English_Level").ionRangeSlider({
                grid: true,
                grid_snap:false,
                from: $("input[name='Typing_English_Level']").val(),
                values: [
                "0-25", "25-50", "51-75", "76-100", "101-125"
                ],
                onChange: function (data) {
                    $('input[name="Typing_English_Level"]').val(data.from);
                }
    });
    $('.datapicker .input-group.date').datepicker({
        todayBtn: "linked",
        keyboardNavigation: false,
        forceParse: false,
        calendarWeeks: true,
        autoclose: true
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
	$("body").on('click','button.save',function(){
        /*$('form').request('onSave', {
            success: function(data) {
                console.log(data);
            }
        });*/
    }).on('click','#upImage',function(){
        $('#PhotoFile').trigger('click'); 
    }).on('change','#PhotoFile',function(){
        $('form').request('onUpload', {
            success: function(data) {
                $("#ImgProfile").attr('src',data[0].thumb);
                $('input[name="Photos"]').val(data[0].file_name);
                $('input[name="path"]').val(data[0].path);
                $('input[name="thumb"]').val(data[0].thumb);
            }
        });
    }).on('click','.gender',function(){
        if(this.id=="Male"){
            var ImgMale = $("#ImgMale").attr('src');
            var ImgMaleReplace = ImgMale.replace('male.png','male_hover.png');
            $("#ImgMale").attr('src',ImgMaleReplace);

            var ImgFemale = $("#ImgFemale").attr('src');
            var ImgFemaleReplace = ImgFemale.replace('female_hover.png','female.png');
            $("#ImgFemale").attr('src',ImgFemaleReplace);

            var idGender=1;
            $('input[name="idGender"]').val('1');
        }else{
            var ImgMale = $("#ImgMale").attr('src');
            var ImgMaleReplace = ImgMale.replace('male_hover.png','male.png');
            $("#ImgMale").attr('src',ImgMaleReplace);

            var ImgFemale = $("#ImgFemale").attr('src');
            var ImgFemaleReplace = ImgFemale.replace('female.png','female_hover.png');
            $("#ImgFemale").attr('src',ImgFemaleReplace);

            var idGender=2;
            $('input[name="idGender"]').val('2');
        }
        $.request('onGetPrefix', {
            data: {value: idGender},
            success: function(data) {
                $('#idPrefix').children('option:not(:first)').remove();
                $.each(data, function(k, v) {
                    $('#idPrefix').append($('<option>', {
                        value: v.id,
                        text: v.Name_TH
                    }));
                });
                if(idGender==1){
                    $('#idPrefix').val(1);
                }else{
                    $('#idPrefix').val(2);
                }
                $('select.chosen').trigger("chosen:updated");
            }
        });
    }).on("click",".Type_Candidate",function(){
        if(this.id=="newGraduate"){
            var ImgNewGrad = $("#ImgNewGrad").attr('src');
            var ImgNewGradReplace = ImgNewGrad.replace('NewGrad.png','NewGrad_hover.png');
            $("#ImgNewGrad").attr('src',ImgNewGradReplace);

            var ImgExp = $("#ImgExp").attr('src');
            var ImgExpReplace = ImgExp.replace('Exp_hover.png','Exp.png');
            $("#ImgExp").attr('src',ImgExpReplace);
            $('input[name="Type_Candidate"]').val('1');
            $(".boxRefExperience").addClass('hidden');
            getSeniority(1,'');
        }else{
            var ImgNewGrad = $("#ImgNewGrad").attr('src');
            var ImgNewGradReplace = ImgNewGrad.replace('NewGrad_hover.png','NewGrad.png');
            $("#ImgNewGrad").attr('src',ImgNewGradReplace);

            var ImgExp = $("#ImgExp").attr('src');
            var ImgExpReplace = ImgExp.replace('Exp.png','Exp_hover.png');
            $("#ImgExp").attr('src',ImgExpReplace);
            $('input[name="Type_Candidate"]').val('2');
            $(".boxRefExperience").removeClass('hidden');
            getSeniority(2,'');
        }
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
                $('select.chosen').trigger("chosen:updated");
            }
        });
    }).on("change","#job_CategoryNew",function(){
        $.request('onGetJobTitle', {
            data: {value: this.value},
            success: function(data) {
                $(".boxSkillList").addClass('hidden'); 
                $('#Job_TitleRequire').children('option:not(:first)').remove();
                $.each(data, function(k, v) {
                    $('#Job_TitleRequire').append($('<option>', {
                        value: v.id,
                        text: v.Name_TH
                    }));
                });
                $('select.chosen').trigger("chosen:updated");
            }
        });
    }).on('change','#Job_TitleRequire',function(){
        $.request('onGetSkillList', {
            data: {value: this.value},
            success: function(data) {
                $('#idSkill_List').children('option:not(:first)').remove();
                $.each(data, function(k, v) {
                    $('#idSkill_List').append($('<option>', {
                        value: v.id,
                        text: v.Name_TH
                    }));
                });
                if(data.length > 0){
                    var instance = $("#ionrangeSkillListLevel").data("ionRangeSlider");
                    instance.update({
                        from: 0 ,
                    });
                    $("input[name='ionrangeSkillListLevel']").val('0');
                    $("input[name='chkValidateSkill']").val('yes');
                    $(".boxSkillList").removeClass('hidden'); 
                }else{
                    $(".boxSkillList").addClass('hidden'); 
                    $("input[name='chkValidateSkill']").val('no');
                }
                $('select.chosen').trigger("chosen:updated");
            }
        });
    }).on('change','#idSkill_List',function(){
        var instance = $("#ionrangeSkillListLevel").data("ionRangeSlider");
        instance.update({
            from: 0 ,
        });
        $("input[name='ionrangeSkillListLevel']").val('0');
    }).on("change","#idInstitute_Detail",function(){
        $.request('onGetEducationLevel', {
            data: {value: this.value},
             success: function(data) {
                $('#idEducation_Level').children('option:not(:first)').remove();
                $.each(data, function(k, v) {
                    $('#idEducation_Level').append($('<option>', {
                        value: v.id,
                        text: v.Name_TH
                    }));
                });
                $('select.chosen').trigger("chosen:updated");
             }
        });
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
    }).on('change','#idEducation_Level',function(){
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
    }).on('change','#Provinces',function(){
        if(this.value!=0){
            callComponent("onGetDistrict",this.value,"#District",'0');
        }
    }).on('change','#District',function(){
        if(this.value!=0){
            callComponent("onGetSubDistrict",this.value,"#SubDistrict",'0');
        }
    }).on('click','.source_type',function(){
        $(".source_type").addClass("btn-outline");
        if($(this).hasClass("btn-outline")==true){
            $(this).removeClass("btn-outline");
        }
        var spl=this.id.split("_");
        $('input[name="idSources_Type"]').val(spl[1]);
        if(spl[1]=="99"){
            $("#OtherType").removeClass("hidden");
        }else{
            $("#OtherType").addClass("hidden");
        }
    }).on('click','.JobSeeking',function(){
        $(".JobSeeking").addClass("btn-outline");
        if($(this).hasClass("btn-outline")==true){
            $(this).removeClass("btn-outline");
        }
        var spl=this.id.split("_");
        $('input[name="idJob_Seeking_Status"]').val(spl[1]);
    }).on('click','.TypeofEmployment',function(){
        $(".TypeofEmployment").addClass("btn-outline");
        if($(this).hasClass("btn-outline")==true){
            $(this).removeClass("btn-outline");
        }
        var spl=this.id.split("_");
        $('input[name="idType_of_Employment"]').val(spl[1]);
    }).on('click','.ExperienceWorkStatus',function(){
        $(".ExperienceWorkStatus").addClass("btn-outline");
        if($(this).hasClass("btn-outline")==true){
            $(this).removeClass("btn-outline");
        }
        var spl=this.id.split("_");
        $('input[name="idExperience_Work_Status"]').val(spl[1]);
        if(spl[1]==2){
            $('.DateEnd').removeClass('hidden');
        }else{
            $('.DateEnd').addClass('hidden');
        }
    }).on('click','.Availability',function(){
        $(".Availability").addClass("btn-outline");
        if($(this).hasClass("btn-outline")==true){
            $(this).removeClass("btn-outline");
        }
        var spl=this.id.split("_");
        $('input[name="idAvailability_of_Work"]').val(spl[1]);
    }).on('change','.chooseTran',function(){
        var TranSpl=this.id.split('_');
        if(this.value!=""){
            $("#"+TranSpl[0]).prop('checked',true).val(this.value);
        }else{
            $("#"+TranSpl[0]).prop('checked',false).val('');
        }
    }).on('change','#idCommunication_Provider',function(){
        if(this.value=="5"){
            $(".boxComunication").removeClass('hidden');
        }else{
            $(".boxComunication").addClass('hidden');
        }
    });
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
    $("#Provinces").each(function(){
        if(this.value!=0){
            callComponent("onGetDistrict",this.value,"#District",$('#temDistrict').val());
        }
    });
    $("#District").each(function(){
        if(this.value!=0){
            callComponent("onGetSubDistrict",$('#temDistrict').val(),"#SubDistrict",$('#temSubdistricts').val());
        }
    });
    $('#tempidInstitute_Detail').each(function(){
        if(this.value!=""){
            $.request('onGetEducationLevel', {
                data: {value: this.value},
                 success: function(data) {
                    $('#idEducation_Level').children('option:not(:first)').remove();
                    $.each(data, function(k, v) {
                        $('#idEducation_Level').append($('<option>', {
                            value: v.id,
                            text: v.Name_TH
                        }));
                    });
                    $("#idEducation_Level").val($("#tempidEducation_Level").val());
                    $('select.chosen').trigger("chosen:updated");
                 }
            });
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

    $("input[name='Type_Candidate']").each(function(){
        if(this.value=="" || this.value=="1"){
            $(".boxRefExperience").addClass('hidden');
             getSeniority(1,$('input[name="temSeniority"]').val());
        }else{
            $(".boxRefExperience").removeClass('hidden');
             getSeniority(2,$('input[name="temSeniority"]').val());
        }
    });

    $("#job_CategoryNew").each(function(){
        $.request('onGetJobTitle', {
            data: {value: this.value},
            success: function(data) {
                $('#Job_TitleRequire').children('option:not(:first)').remove();
                $.each(data, function(k, v) {
                    $('#Job_TitleRequire').append($('<option>', {
                        value: v.id,
                        text: v.Name_TH
                    }));
                });
                $("#Job_TitleRequire").val($("input[name='tempJob_TitleRequire']").val());
                $('select.chosen').trigger("chosen:updated");
            }
        });
    });

    $("input[name='tempJob_TitleRequire']").each(function(){
        $.request('onGetSkillList', {
            data: {value: this.value},
            success: function(data) {
                $('#idSkill_List').children('option:not(:first)').remove();
                $.each(data, function(k, v) {
                    $('#idSkill_List').append($('<option>', {
                        value: v.id,
                        text: v.Name_TH
                    }));
                });
                if(data.length > 0){
                    $(".boxSkillList").removeClass('hidden'); 
                    $("input[name='chkValidateSkill']").val('yes');
                }else{
                    $(".boxSkillList").addClass('hidden'); 
                    $("input[name='chkValidateSkill']").val('no');
                }
                $('#idSkill_List').val($('input[name="tempidSkill_List"]').val());
                $('select.chosen').trigger("chosen:updated");
            }
        });
    });
});