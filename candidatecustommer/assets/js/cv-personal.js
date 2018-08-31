$(document).ready(function(){
	$('.dateMobile').scroller({ theme: 'android-ics light' });
    var now = new Date();
    $('.BirthDate').scroller({ 
        theme: 'android-ics light',
        startYear: (now.getFullYear()+543)-50,
        endYear: (now.getFullYear()+543)-18,
        setText: 'เลือก',
        cancelText: 'ยกเลิก',
        monthNamesShort:['ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ส.ค.', 'ก.ย.', 'ต.ค.', 'พ.ย.', 'ธ.ค.'],
    });
	var lines = 6;
    var linesUsed = $('#linesUsed');

    $('.notes').keydown(function(e) {

        newLines = $(this).val().split("\n").length;
        linesUsed.text(newLines);

        if(e.keyCode == 13 && newLines >= lines) {
            e.preventDefault();
        }
        
    });
    $('select.chosen').chosen({
        width: "100%",
        search_contains: true
    });

    $('body').on('click','button.save',function(){
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
    }).on('click','.JobSeeking',function(){
        $(".JobSeeking").addClass("btn-outline");
        $('.imgJobSeek').addClass('grayscaled');
        var spl=this.id.split("_");
        if($("#JobSeeking_"+spl[1]).hasClass("btn-outline")==true){
            $("#JobSeeking_"+spl[1]).removeClass("btn-outline");
        }
        $('#JobSeekingStatus_'+spl[1]).prop('checked',true);
        $('#imgJobSeek'+spl[1]).removeClass('grayscaled');
    }).on('change','#idCommunication_Provider',function(){
        if(this.value=="5"){
            $(".boxComunication").removeClass('hidden');
        }else{
            $(".boxComunication").addClass('hidden');
        }
    });
});