$(function() {
	var cmd_arr	= {};
	cmd_arr = getUrlVars();
	var base_link = BASENAME;	
	var objFiltred = {
		objSubstation: $('#substation'),
		objCounter: $('#counter'),
		url_substation: 'models/json/get_substation_filtred.php',
		url_counter: 'models/json/get_counter_filtred.php'
	};	
	
	json_get_table($('#right'), cmd_arr);
	$.datepicker.setDefaults(
		$.extend($.datepicker.regional["ru"])
	);
	
	// Востанавливаем значения фильтров если была перезагрузка страницы через F5 или обновить
	if (('id_lot' in cmd_arr) && ('id_sub' in cmd_arr) && ('id_counter' in cmd_arr))	{
		   $('#lot [value="' + cmd_arr.id_lot + '"]').prop("selected", true);
		   get_substation(objFiltred, cmd_arr.id_lot, 2, cmd_arr.id_sub, cmd_arr.id_counter);
		   
	} else {
		if (('id_lot' in cmd_arr) && ('id_sub' in cmd_arr))	{
			   $('#lot [value="' + cmd_arr.id_lot + '"]').prop("selected", true);
			   get_substation(objFiltred, cmd_arr.id_lot, 2, cmd_arr.id_sub);
		} else {
			if ('id_lot' in cmd_arr)	{
				 $('#lot [value="' + cmd_arr.id_lot + '"]').prop("selected", true);
				 get_substation(objFiltred, cmd_arr.id_lot);					 
			}	  
		}
	}			
	$('#lot').change(function () {
		var lot = $(this).val();
		cmd_arr.id_lot = lot;
		if (lot == 0) {
			delete cmd_arr.id_lot;
			delete cmd_arr.id_sub;
			delete cmd_arr.id_counter;
			delete cmd_arr.st;
		} else { 
			delete cmd_arr.st;
			delete cmd_arr.id_sub;
			$('#substation').prop('disabled', false);
		}
		
		get_substation(objFiltred, lot);
		json_get_table($('#right'), cmd_arr);
		history.pushState(null, null, create_cmd(base_link, cmd_arr));
						
	});
// Изменение подстанции фильр выбора		
	$('#substation').change(function () {
		var lot = $( '#lot' ).val();
		var substation = $(this).val();
		cmd_arr.id_lot = lot;
		cmd_arr.id_sub = substation;
		
		if (substation == 0) {	
			delete cmd_arr.id_sub;
			delete cmd_arr.id_counter;
			delete cmd_arr.st;
		
		} else {
			delete cmd_arr.st;
			delete cmd_arr.id_counter;
		}	
		var div_filtrCounter = $('#counter');			
		get_counter(div_filtrCounter, 'models/json/get_counter_filtred.php', substation);
		json_get_table($('#right'), cmd_arr);
		history.pushState(null, null, create_cmd(base_link, cmd_arr));
						
	});
// Изменение ячейки фильр выбора		
	$('#counter').change(function () {
		cmd_arr.id_lot = $('#lot').val();
		cmd_arr.id_sub = $('#substation').val();
		cmd_arr.id_counter = $(this).val();
		json_get_table($('#right'), cmd_arr);
		history.pushState(null, null, create_cmd(base_link, cmd_arr));
	});

	$('.filtred_checkbox').on('click', function(e){  
		var checkbox_id = $(this).attr('id');
		var lot = $('#lot').val();

		if ((checkbox_id == 'dt1_en'))
			if ($('#dt1_en').prop('checked')) {  
				delete cmd_arr.st;

				$('#dt2_en').prop('disabled', false);

				$( "#dt1" ).datepicker('enable');
				cmd_arr.date_b = $("#dt1").datepicker().val();
				json_get_table($('#right'), cmd_arr);
				history.pushState(null, null, create_cmd(base_link, cmd_arr));
				
			} else { 
				delete cmd_arr.date_b;
				delete cmd_arr.st;
				delete cmd_arr.date_e;

				$('#dt2_en').prop('disabled', true);
				$('#dt2_en').prop('checked', false);

				
				$( "#dt1" ).datepicker('disable');					
				$( "#dt2" ).datepicker('disable');					
				
				json_get_table($('#right'), cmd_arr);
				history.pushState(null, null, create_cmd(base_link, cmd_arr));
			}

		if ((checkbox_id == 'dt2_en'))
			if ($('#dt2_en').prop('checked')) {  
				delete cmd_arr.st;

				$( "#dt2" ).datepicker('enable');
				cmd_arr.date_e = $("#dt2").datepicker().val();
				json_get_table($('#right'), cmd_arr);
				history.pushState(null, null, create_cmd(base_link, cmd_arr));
				
			} else { 
				delete cmd_arr.date_e;
				delete cmd_arr.st;

				$( "#dt2" ).datepicker('disable');					
				json_get_table($('#right'), cmd_arr);
				history.pushState(null, null, create_cmd(base_link, cmd_arr));
			}
	});

	$( "#dt1" ).datepicker({changeYear: true, changeMonth: true, minDate: '2016-01-01', maxDate: '0', dateFormat: 'yy-mm-dd',
		onSelect: function(dateText, inst) {
			cmd_arr.date_b = dateText;
			json_get_table($('#right'), cmd_arr);
		}
	});

	$( "#dt2" ).datepicker({changeYear: true, changeMonth: true, minDate: '2016-01-01', maxDate: '0', dateFormat: 'yy-mm-dd',
		onSelect: function(dateText, inst) {
			cmd_arr.date_e = dateText;
			json_get_table($('#right'), cmd_arr);
		}
	});

	if (!$('#dt1_en').prop('checked')) $( "#dt1" ).datepicker('disable');
	if (!$('#dt2_en').prop('checked')) $( "#dt2" ).datepicker('disable');

	$('#right').on('click','a',function( event ) {
		event.preventDefault();
		// console.log(event.target.search);
		var param = event.target.search;
		if (param != '') {
			var stArr = (param.substr(1)).split('&');
			for(var i=0; i < stArr.length; i++) {
				st =  stArr[i].split('=');       // массив param будет содержать
				if (st[0] == 'st' ) {
					if (st[1] != 0) cmd_arr.st = st[1]; else delete cmd_arr.st;
				}	
			}			
		}
		json_get_table($('#right'), cmd_arr);
	});	
});