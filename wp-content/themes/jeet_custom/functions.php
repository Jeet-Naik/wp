<?php 
function my_cuncas(){
    echo "Hello";
}
add_action('my_action','my_cuncas');

function my_filterr(){
    echo "my filter content";
}
add_filter('my_filter','my_filterr')
?>