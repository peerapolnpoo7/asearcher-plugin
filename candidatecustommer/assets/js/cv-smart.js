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
        startYear: (now.getFullYear()+543)-100,
        endYear: (now.getFullYear()+543)-18,
        monthNamesShort:['ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ส.ค.', 'ก.ย.', 'ต.ค.', 'พ.ย.', 'ธ.ค.'],
    });
    $('.dateMobileStart').scroller({ 
        theme: 'android-ics light',
        startYear: (now.getFullYear()+543)-100,
        endYear: (now.getFullYear()+543),
        monthNamesShort:['ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ส.ค.', 'ก.ย.', 'ต.ค.', 'พ.ย.', 'ธ.ค.'],
    });
    $('.dateMobileEnd').scroller({ 
        theme: 'android-ics light',
        startYear: (now.getFullYear()+543)-100,
        endYear: (now.getFullYear()+543),
        monthNamesShort:['ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ส.ค.', 'ก.ย.', 'ต.ค.', 'พ.ย.', 'ธ.ค.'],
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
    }).on("change","#job_CategoryNew",function(){
        $('#boxJob_TitleRequireOther,#boxSkill_ListOther').addClass('hidden');
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
                $('#Job_TitleRequire').append($('<option>', {
                        value: 'other',
                        text: 'อื่นๆ'
                    }));
                $('select.chosen').trigger("chosen:updated");
            }
        });
    }).on('change','#Job_TitleRequire',function(){
        $('#boxSkill_ListOther').addClass('hidden');
        if(this.value=="other"){
            $('#boxJob_TitleRequireOther').removeClass('hidden');
            $(".boxSkillList").addClass('hidden');
            $("input[name='chkValidateSkill']").val('no');
            $('#Job_TitleRequireOther').focus();
        }else{
            $('#boxJob_TitleRequireOther').addClass('hidden');
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
                        $('#idSkill_List').append($('<option>', {
                            value: 'other',
                            text: 'อื่นๆ'
                        }));
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
        }
    }).on('change','#idSkill_List',function(){
        if(this.value=="other"){
            $('#boxSkill_ListOther').removeClass('hidden');
            $('input#idSkill_ListOther').focus();
        }
        var instance = $("#ionrangeSkillListLevel").data("ionRangeSlider");
        instance.update({
            from: 0 ,
        });
        $("input[name='ionrangeSkillListLevel']").val('0');
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
            $('#boxidGeography,#boxtype_of_institue,#boxidInstitute_Detail,#boxidFaculty_Detail,#boxidDepartment,#boxidMajor_Subject,#boxidDegree_and_Certificate,#boxGPA').addClass('hidden');
        }else if(this.value=="1"){
            $('#boxidGeography,#boxtype_of_institue,#boxidInstitute_Detail,#boxidFaculty_Detail,#boxidDepartment,#boxidMajor_Subject').addClass('hidden');
            $('#boxidDegree_and_Certificate,#boxGPA').removeClass('hidden');
        }else{
            $('#boxidGeography,#boxtype_of_institue,#boxidInstitute_Detail').removeClass('hidden');
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
        $('.imgSourceType').addClass('grayscaled');
        var spl=this.id.split("_");
        if($(this).hasClass("btn-outline")==true){
            $(this).removeClass("btn-outline");
        }
        
       // $('input[name="idSources_Type"]').val(spl[1]);
        $('#SourcesType_'+spl[1]).prop('checked',true);
        $('#imgSourceType'+spl[1]).removeClass('grayscaled');
        if(spl[1]=="99"){
            $("#boxidSources_TypeOther").removeClass("hidden");
        }else{
            $("#boxidSources_TypeOther").addClass("hidden");
        }
    }).on('click','.JobSeeking',function(){
        $(".JobSeeking").addClass("btn-outline");
        $('.imgJobSeek').addClass('grayscaled');
        var spl=this.id.split("_");
        if($("#JobSeeking_"+spl[1]).hasClass("btn-outline")==true){
            $("#JobSeeking_"+spl[1]).removeClass("btn-outline");
        }
        $('#JobSeekingStatus_'+spl[1]).prop('checked',true);
        $('#imgJobSeek'+spl[1]).removeClass('grayscaled');
    }).on('click','.TypeofEmployment',function(){
        var spl=this.id.split("_");
        if(this.checked == true){
            $('#isDelTypeEmp'+spl[1]).val('N');
            $('#imgTypeEmp'+spl[1]).removeClass('grayscaled');
            if(spl[1]=='1'){
                $('#boxWelFares').removeClass('hidden');
                $(".select2-container").css('width','100%');
            }
        }else{
            $('#isDelTypeEmp'+spl[1]).val('Y');
            $('#imgTypeEmp'+spl[1]).addClass('grayscaled');
            if(spl[1]=='1'){
                $('#boxWelFares').addClass('hidden');
            }
        }
    }).on('click','.idTypeofEmployment',function(){
       var spl=this.id.split("_");
        if($(this).hasClass("btn-outline")==true){
            $(this).removeClass("btn-outline");
            $('#idTypeofEmployment_'+spl[1]).prop('checked',true);
            if(spl[1]=='1'){
                $('#boxWelFares').removeClass('hidden');
                $(".select2-container").css('width','100%');
            }
        }else{
            $(this).addClass("btn-outline");
            $('#idTypeofEmployment_'+spl[1]).prop('checked',false);
            if(spl[1]=='1'){
                $('#boxWelFares').addClass('hidden');
            }
        }
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
    }).on('click','input[name="ExperienceWorkStatus"]',function(){
        $('input[name="idExperience_Work_Status"]').val(this.value);
        if(this.value==2){
            var Img = $("#ImageWorkStatus"+this.value).attr('src');
            var ImgReplace = Img.replace('Resigned.png','Resigned_hover.png');
            $("#ImageWorkStatus"+this.value).attr('src',ImgReplace);
            var Img = $("#ImageWorkStatus1").attr('src');
            var ImgReplace = Img.replace('Working_hover.png','Working.png');
            $("#ImageWorkStatus1").attr('src',ImgReplace);
            $('.DateEnd').removeClass('hidden');
        }else{
            var Img = $("#ImageWorkStatus"+this.value).attr('src');
            var ImgReplace = Img.replace('Working.png','Working_hover.png');
            $("#ImageWorkStatus"+this.value).attr('src',ImgReplace);
            var Img = $("#ImageWorkStatus2").attr('src');
            var ImgReplace = Img.replace('Resigned_hover.png','Resigned.png');
            $("#ImageWorkStatus2").attr('src',ImgReplace);
            $('.DateEnd').addClass('hidden');
        }
    }).on('click','.Availability',function(){
        $(".Availability").addClass("btn-outline");
        $('.imgAvailability').addClass('grayscaled');
        if($(this).hasClass("btn-outline")==true){
            $(this).removeClass("btn-outline");
        }
        var spl=this.id.split("_");
        $('#AvailabilityofWork_'+spl[1]).prop('checked',true);
        $('#imgAvailability'+spl[1]).removeClass('grayscaled');
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
    }).on('change','#LangidCountry_Calling_Code',function(){
        $("#ionrangeListenLevel").data("ionRangeSlider").update({from: 0});
        $("#ionrangeSpeakingLevel").data("ionRangeSlider").update({from: 0});
        $("#ionrangeReadingLevel").data("ionRangeSlider").update({from: 0});
        $("#ionrangeWritingLevel").data("ionRangeSlider").update({from: 0});
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
    $("#temDistrict").each(function(){
        if(this.value!=0){
            callComponent("onGetSubDistrict",$('#temDistrict').val(),"#SubDistrict",$('#temSubdistricts').val());
        }
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
                if(data.length > 0){
                    $('#Job_TitleRequire').append($('<option>', {
                        value: 'other',
                        text: 'อื่นๆ'
                    }));
                }
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
                    $('#idSkill_List').append($('<option>', {
                            value: 'other',
                            text: 'อื่นๆ'
                        }));
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