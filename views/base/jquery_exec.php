	$(document).on('click', 'a#add_value', function(e) {	e.preventDefault();	$.colorbox({href:$(this).attr('href'), width:"900px",height:"90%",iframe:true});});
