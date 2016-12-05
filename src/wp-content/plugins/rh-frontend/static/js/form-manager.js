jQuery(document).ready(function($){
	
	$( "#wpfepp-sortable" ).sortable({helper : 'clone'});
	$('body').on('click', ".wpfepp-widget-head", function(e){
		$(this).find('.wpfepp-expand i').first().toggleClass('wpfepp-icon-arrow-down').toggleClass('wpfepp-icon-arrow-up');
		$(this).siblings('.wpfepp-widget-body').first().slideToggle();
	});
	$('body').on('click', ".wpfepp-custom-field-delete i.wpfepp-icon-remove", function(e){
		var confirmation = confirm('Are you sure?');
		if(confirmation)
			$(this).closest('.wpfepp-widget-container').remove();
		e.stopPropagation();
	});
	$('select.wpfepp_element').each(function(){
		$(this).closest('.form-table').find('.wpfepp_step_count, .wpfepp_min_number, .wpfepp_max_number').closest('tr').hide();
	    if( $(this).val()==="inputnumb"){
	    	$(this).closest('.form-table').find('.wpfepp_step_count, .wpfepp_min_number, .wpfepp_max_number').closest('tr').show();
	    }		
	});
	$('body').on('change','select.wpfepp_element',function(){
	    if( $(this).val()==="inputnumb"){
	    	$(this).closest('.form-table').find('.wpfepp_step_count, .wpfepp_min_number, .wpfepp_max_number').closest('tr').show();
	    }
	    else{
	    	$(this).closest('.form-table').find('.wpfepp_step_count, .wpfepp_min_number, .wpfepp_max_number').closest('tr').hide();
	    }
	});	
	function wpfepp_ajax_form_submit(click_event, clicked, callback){
		click_event.preventDefault();
		loading_img = $('#wpfepp-loading');
		var parent_form = clicked.closest('.wpfepp-ajax-form');
		parent_form.find('input[type="text"].wpfepp-required').each(function(){
			if(!$.trim(this.value).length) $(this).addClass('error'); else $(this).removeClass('error');
		});
		if($('.wpfepp-ajax-form .error').length)
			return;
		loading_img.show();
		$.ajax({
			type:'POST',
			dataType: 'json',
			url: ajaxurl,
			data: parent_form.serialize(),
			success: function(data, textStatus, XMLHttpRequest){
				loading_img.hide();
				if(data.success){
					parent_form.find('input[type="text"], textarea').val('');
					callback(data);
				}
				else{
					loading_img.hide();
					alert(data.error);
				}
			},
			error:function(MLHttpRequest,textStatus,errorThrown){
				alert(errorThrown);
			}
		});
	}

	$('body').on('focus', '.wpfepp-ajax-form input[type="text"].error', function(){
		$(this).removeClass('error');
	});

	$('#wpfepp-add-custom-field').click(function(e){
		wpfepp_ajax_form_submit(e, $(this), function(data){
			$('#wpfepp-sortable').append(data.widget_html);
			$('.wpfepp-widget-container:last-child').find('.wpfepp_step_count, .wpfepp_min_number, .wpfepp_max_number').closest('tr').hide();
		});				
	});
	$('#wpfepp-create-form').click(function(e){
		wpfepp_ajax_form_submit(e, $(this), function(data){
			$('#wpfepp-form-list-table-container').html(data.table_html);
		});
	});

	

});


		

