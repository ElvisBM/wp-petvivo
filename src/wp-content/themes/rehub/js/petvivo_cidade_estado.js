/* global wcPagarmeParams, PagarMe */
(function( $ ) {
	'use strict';
	$( function() {	

		//add cidade estado plg
		var count_state = $( '.js-count-state' ).length;
		for(var i = 1; i <= count_state; i++){
			var cidade = 'cidade'+i;
			var estado = 'estado'+i;
			new dgCidadesEstados({
		        cidade: document.getElementById(cidade),
		        estado: document.getElementById(estado)
		    })
		};

		$('.insert').on( 'focusout', function(){

			var count = $( '.js-count-state' ).length;
			
			$("#estado").addClass('js-count-state');

			var estado = 'estado'+(count+1);
			var cidade = 'cidade'+(count+1);

			$('#estado').attr( "id" , estado );
			$('#cidade').attr( "id" , cidade );

			new dgCidadesEstados({
		        cidade: document.getElementById(cidade),
		        estado: document.getElementById(estado)
		    })

		});

	});
}( jQuery ));