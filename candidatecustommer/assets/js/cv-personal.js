$(document).ready(function(){
	$('.dateMobile').scroller({ theme: 'android-ics light' });
	var lines = 6;
    var linesUsed = $('#linesUsed');

    $('.notes').keydown(function(e) {

        newLines = $(this).val().split("\n").length;
        linesUsed.text(newLines);

        if(e.keyCode == 13 && newLines >= lines) {
            e.preventDefault();
        }
        
    });
});