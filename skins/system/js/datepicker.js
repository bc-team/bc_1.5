$(document).ready(function() {
	$("#datepicker")
			.datepicker(
					{
						showOn : "button",
						buttonImage : "skins/system/images/Calendar-icon18x18.png",
						buttonImageOnly : true,
						dateFormat : "dd/mm/yy",
						monthNames : [ "Gennaio", "Febbraio", "Marzo",
								"Aprile", "Maggio", "Giugno", "Luglio",
								"Agosto", "Settembre", "Ottobre", "Novembre",
								"Dicembre" ]
					});
	$.datepicker.setDefaults($.datepicker.regional["it"]);
});