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

	jQuery( ".js-category, .js-date" ).on( "change", function() {
		ajaxTestFunction() ;	
	});

	// And add a listener/callback for the pagination clicks.
	jQuery( '.filtered-posts' ).on( 'click', '.page-numbers', function( e ){
		e.preventDefault();
	
		// var paged = /[\?&]paged=(\d+)/.test( this.href ) && RegExp.$1;
		var paged=$(this).text();
			// alert($(this).text());
			// $(this).attr('href');
			
		// alert(paged);
		ajaxTestFunction( paged );
	});


	//display posts function
	function ajaxTestFunction( page_num ) {
		
		if( page_num == undefined)
		{
			page_num=1;
		};
		// alert(page_num);
		var category = $( '.js-category' ).val();
		var date = $( '.js-date' ).val()
        // alert(category);
		data = {
			'action': 'filterposts',
			'category': category,
			'date': date,
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
				if ( data ) {
                    
					$('.filtered-posts').html( data.posts );

					$('.js-category').removeAttr('disabled');
					$('.js-date').removeAttr('disabled');
                    
				} else {
					$('.filtered-posts').html( 'No posts found.' );
				}
			}
		});
	}
});