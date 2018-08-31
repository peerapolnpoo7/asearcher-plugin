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
$(document).ready(function(){
	$('select.chosen').chosen({
		width: "100%",
		search_contains: true
	});
	$("body").on("click",".Btn-PerAdd",function(){
		$(".Btn-PerAdd").addClass("btn-outline");
		if($(this).hasClass("btn-outline")==true){
			$(this).removeClass("btn-outline");
		}
		if(this.id=="PerAdd-Home"){
			$(".boxPerBuilding").addClass('hidden');
			$('#Home_Condo').val('1');
		}else{
			$(".boxPerBuilding").removeClass('hidden');
			$('#Home_Condo').val('2');
		}
	}).on("click","input[name=Address_Present]",function(){
		if(this.value=="1"){
			$(".boxPre").addClass("hidden");
			$(".boxPreBuilding").addClass('hidden');
			$(".Btn-PreAdd").addClass("btn-outline");
			$("#PreAdd-Home").removeClass('btn-outline');
		}else{
			$(".boxPre").removeClass("hidden");
			$("#PreAdd-Home").removeClass('btn-outline');
		}
	}).on("click",".Btn-PreAdd",function(){
		$(".Btn-PreAdd").addClass("btn-outline");
		if($(this).hasClass("btn-outline")==true){
			$(this).removeClass("btn-outline");
		}
		if(this.id=="PreAdd-Home"){
			$(".boxPreBuilding").addClass('hidden');
			$('#Home_Condo_1').val('1');
		}else{
			$(".boxPreBuilding").removeClass('hidden');
			$('#Home_Condo_1').val('2');
		}
	}).on('change','#idProvinces',function(){
		callComponent("onGetDistrict",this.value,"#idDistricts",'0');
	}).on('change','#idDistricts',function(){
		callComponent("onGetSubDistrict",this.value,"#idSubdistricts",'0');
	}).on('change','#idSubdistricts',function(){
		$.request('onGetPostcode', {
			data: {value: this.value},
			success: function(data) {
				$('#Postcode').val(data.Code);
			}
		});
	}).on('change','#idProvinces_1',function(){
		callComponent("onGetDistrict",this.value,"#idDistricts_1",'0');
	}).on('change','#idDistricts_1',function(){
		callComponent("onGetSubDistrict",this.value,"#idSubdistrict_1",'0');
	}).on('change','#idSubdistrict_1',function(){
		$.request('onGetPostcode', {
			data: {value: this.value},
			success: function(data) {
				$('#Postcode1').val(data.Code);
			}
		});
	});
	$("#Home_Condo").each(function(){
		if(this.value=="1"){
			$(".boxPerBuilding").addClass('hidden');
		}else{
			$(".boxPerBuilding").removeClass('hidden');
		}
	});
	$("#Home_Condo_1").each(function(){
		if(this.value=="1"){
			$(".boxPreBuilding").addClass('hidden');
		}else{
			$(".boxPreBuilding").removeClass('hidden');
		}
	});
	//Test
	$("#idProvinces").each(function(){
		callComponent("onGetDistrict",this.value,"#idDistricts",$('#temDistrict').val());
	});
	$("#idDistricts").each(function(){
		callComponent("onGetSubDistrict",$('#temDistrict').val(),"#idSubdistricts",$('#temSubdistricts').val());
	});
	$("#idProvinces_1").each(function(){
		callComponent("onGetDistrict",this.value,"#idDistricts_1",$('#temDistricts_1').val());
	});
	$("#idDistricts_1").each(function(){
		callComponent("onGetSubDistrict",$('#temDistricts_1').val(),"#idSubdistrict_1",$('#temSubdistrict_1').val());
	});
	$("input[name='Address_Present']").each(function(){
		if(this.checked==true){
			if(this.value=="1"){
				$(".boxPre").addClass("hidden");
				$(".boxPreBuilding").addClass('hidden');
				$(".Btn-PreAdd").addClass("btn-outline");
			}else{
				$(".boxPre").removeClass("hidden");
			}
		}
	});
});