/* global wcPagarmeParams, PagarMe */
(function( $ ) {
	'use strict';
	$( function() {

		//Hide dashboardmenu page setting
		var classActive = $('#dashboard-menu-item-settings').attr('class');
		if( classActive != "active" ){
			$('.wcv-navigation').show();
			$('.title').show();
		}	

		//show save button settings
		$('.tabs-tab').on( 'click', function(){
			$('#save_button').show();
		});

		//hide save button settings adress
		$('.tabs-tab.adress').on( 'click', function(){
			$('#save_button').hide();
		});

		//Redirect btn tab-nav gerenciarloja
		$('.gerenciar-loja-js').on( 'click', function(){
			var page = $(this).attr('href');
			$(location).attr('href', page );
		});

		


	});
}( jQuery ));