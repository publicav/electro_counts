$(function(){
	var gl_add_counts = 0, buttonpressed;
	var edit_arr = new Array()
	var objSelected = {
		objLot: 	  	 $( '#lot' ),
		objSubstation:	 $( '#substation' ),
 		objCounter:   	 $( '#counter' ),
 		objCounterLastVal: $( '#counter_last_val' ),
		url_substation: 'models/json/get_substation.php',
		url_counter:    'models/json/get_counter.php'
	};	
	
	$( '#date_airing_begin' ).datepicker( {changeYear: true, dateFormat: 'dd-mm-yy'} );
	
	$.mask.definitions['H']='[012]';
	$.mask.definitions['M']='[012345]';
	$.mask.definitions['F']='[0-9.]+';
	$('#time_airing_begin').mask('H9:M9');

	get_substation(objSelected, $('#lot').val());	

	$( '#lot' ).change(function () {
		let lot = $( this ).val();
		get_substation( objSelected, lot );	
		$('#counter_val').val('');
		let counter = objSelected.objCounter.val();
		objSelected.param = {'counter': counter};
	});

	$( '#substation' ).change(function () {
		let substation = $( this ).val();
		get_counter( objSelected, substation);	
		$('#counter_val').val('');
	});
	$( '#counter' ).change(function () {
		$('#counter_val').val( '' );
		let counter = $( this ).val();
		objSelected.param = {'counter': counter};
		get_last_val( objSelected );
	});
	

		$('#list_counts').on('click','a',function( event ) {
				var arr_id = $( this ).attr('id');
				var index = find_arr_id( edit_arr,arr_id );
				var lot_value = edit_arr[index].lot;
				var substation_value = edit_arr[index].substation;
				var couner_value = edit_arr[index].counter;
				
				$('#lot').find('[value="' + lot_value + '"]').prop("selected", true );		
				
				get_substation( objSelected, lot_value, EDIT_ACTIONS, substation_value, couner_value );
				
				$('#date_airing_begin').val( edit_arr[index].date );		
				$('#time_airing_begin').val( edit_arr[index].time );	
				$('#counter_val').val( edit_arr[index].value );	
				$('#edit_id').val( arr_id );	

				$('#ok_f').button("option", "disabled", true ); // - блокировка элемента с id=ok_f
				$('#edit_f').button("option", "disabled", false ); // - блокировка элемента с id=edit_f
				
				event.preventDefault();
				
		});

		$( 'input[type=submit], a, button').button().
		click(function(){
			buttonpressed = $(this).attr('id');
		});
		
		$('#add_value_counts_form').submit(function(event){
			event.preventDefault();
			me = this;
			btn = {id: buttonpressed};
			buttonpressed = '';
			obj = {
				form: 		me,				
				objBtnOk:	$('#ok_f'),
				objBtnEdit: $('#edit_f'),
				btnPress: 	btn,				
				objListRec: $('#list_counts'),
				gl_add_counts,
				edit_arr,
				__proto__:	 objSelected
			}
			add_form_actions( obj );
			
	  });
	
});