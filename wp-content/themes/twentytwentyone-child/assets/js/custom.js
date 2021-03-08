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