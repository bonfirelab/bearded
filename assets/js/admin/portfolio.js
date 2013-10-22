jQuery(document).ready(function($){
	$('.portfolio-datepicker').datepicker({
		dateFormat : 'DD, MM d, yy',
		onSelect: function(dateText, inst) {
			console.log(dateText);
			console.log(inst);

	        var dateArr = dateText.split(' ');
	        console.log(dateArr);

	        var suffix = "";
	        switch(inst.selectedDay) {
	            case '1': case '21': case '31': suffix = 'st'; break;
	            case '2': case '22': suffix = 'nd'; break;
	            case '3': case '23': suffix = 'rd'; break;
	            default: suffix = 'th';
	        }

	        $(this).val(dateArr[0] + ' ' + dateArr[1] + ' ' + inst.selectedDay + suffix +', '+ dateArr[3]);
	    }
	});

});