//Postmeta uspdate form 
jQuery( document ).ready(function() {
    jQuery(document).on("click","#btnUpdate",function() {
        var pid=jQuery("#pid").val();
        var price=jQuery("#price").val();
        jQuery.ajax({
            url: myAjax.ajaxurl,
            type: "POST",
            async: true, 
            data:{
                'action': 'my_action',
                'pid': pid,
                'price':price
            },
            success: function(data) {
                alert(data);
            },  
        });
    });
});

//fiters
jQuery(document).ready(function($){

	ajaxTestFunction() ;


	jQuery( "#filter" ).on( "click", function() {
		ajaxTestFunction() ;	
	});

	// listener/callback for the pagination clicks.
	jQuery( '.filtered-posts' ).on( 'click', '.page-numbers', function( e ){
		e.preventDefault();
		// var paged=$(this).text();
		var href = $(this).attr('href'); 

		var pageNumber = href.split( "/?page" )[ 0 ].split( "=" ).pop();
		if(!pageNumber)
		{
			pageNumber=1;
		}
		ajaxTestFunction( pageNumber );
	});


	//display posts function
	function ajaxTestFunction( page_num ) {
		
		if( page_num == undefined)
		{
			page_num=1;
		}
	

		var category = $( '.js-category' ).val();
		var price_srt = $( '#price_src' ).val();
	
		data = {
			'action': 'filterposts',
			'category': category,
			'price_srt': price_srt,
			'paged':page_num
		};

		jQuery.ajax({
			url : myAjax.ajaxurl,
			data : data,
			type : 'POST',
			beforeSend : function ( xhr ) {
				$('.filtered-posts').html( 'Loading...' );
				$('.js-category').attr( 'disabled', 'disabled' );
				$('.js-date').attr( 'disabled', 'disabled' );
			},
			success : function( data ) {
                console.log(data);
				var html=data.posts;
				var div=$(html).filter('#pagination');
				$('.page-numbers').removeClass('.page-numbers').addClass('green');
				if ( data ) {
                    
					$('.filtered-posts').html( html );

					$('.js-category').removeAttr('disabled');
					$('.js-date').removeAttr('disabled');
                    
				} else {
					$('.filtered-posts').html( 'No posts found.' );
				}
			}
		});
	}

	jQuery ( window ).load(function() {
		// alert('slidee');
		jQuery('.flexslider').flexslider({
		  animation: "slide"
		});
	});


	(function ($) {
		$( document ).on( 'click', '.single_add_to_cart_button', function(e) {
		e.preventDefault();
		var $thisbutton = $(this),
                $form = $thisbutton.closest('form.cart'),
                id = $thisbutton.val(),
                product_qty = $form.find('input[name=quantity]').val() || 1,
                product_id = $form.find('input[name=product_id]').val() || id,
                variation_id = $form.find('input[name=variation_id]').val() || 0;
				size= $form.find('input[name=attribute_pa_size]').val() || '';
			alert("size"+size);
        var data = {
            action: 'woocommerce_ajax_add_to_cart',
            product_id: product_id,
            product_sku: '',
            quantity: product_qty,
            variation_id: variation_id,
        };
		console.log("Data"+data);

        $(document.body).trigger('adding_to_cart', [$thisbutton, data]);
		if ( $form.find('input[name=variation_id]').length > 0 && variation_id == 0 ) { return false; }
        $.ajax({
            type: 'post',
            url: myAjax.ajaxurl,
            data: data,
            beforeSend: function (response) {
                $thisbutton.removeClass('added').addClass('loading');
            },
            complete: function (response) {
                $thisbutton.addClass('added').removeClass('loading');
            },
            success: function (response) {
				// alert("Item added to cart successfully");
			
				console.log("Response"+response);	
                if (response.error && response.product_url) {
                    window.location = response.product_url;
                    return;
                } 
				// else {
				// 	// $form.hide();
                //     $(document.body).trigger('added_to_cart', [response.fragments, response.cart_hash, $thisbutton]);
                // }
				$( document.body ).trigger( 'added_to_cart', [ response.fragments, response.cart_hash, $thisbutton ] );
				if ( wc_add_to_cart_params.cart_redirect_after_add === 'yes' ) {
					window.location = wc_add_to_cart_params.cart_url;
					return;
				}
				// Remove existing notices
				$( '.woocommerce-error, .woocommerce-message, .woocommerce-info' ).remove();

				// Add new notices
				$form.before(response.fragments.notices_html)
				console.log(("Notice :- "+ response.fragments.notices_html));

				// $form.unblock();
            },
        });

        return false;
		});
		})(jQuery);

		// 	function ($) {
		// 	$( document ).on( 'change', '.game_attribute', function(e) {
		// 		// var category= $('select[name=game_attribute]').val() // Here we can get the value of selected item
		// 		var category= $(this).val() 
		// 		alert(category);
		// 		jQuery.ajax({
		// 			url: myAjax.ajaxurl,
		// 			type: "POST",
		// 			async: true, 
		// 			data:{
		// 				'action': 'filter_by_attribute',
		// 				'category': category,
		// 			},
		// 			success: function(data) {
		// 				alert(data);
		// 			},  
		// 		});
		// 	});
		// })(jQuery);
});