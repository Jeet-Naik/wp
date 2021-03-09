<?php
/*
Template Name: Book list
*/
get_header();

//Filter
?>
<center>
<div class="filter-wrap">
    <div class="category">
        <div class="field-title">Category</div>
        <?php $get_categories = get_categories(array('taxonomy'=>'book_category')); ?>
            <select class="js-category">
				<option value="">--Select--</option>
                <option value="all">All</option>
                <?php
					if ( $get_categories ) :
						foreach ( $get_categories as $cat ) :
					?>
                    <option value="<?php echo $cat->term_id; ?>">
                        <?php echo $cat->name; ?>
                    </option>
                    <?php endforeach; 
						endif;
					?>
            </select>
    </div>
 
    <!-- <div class="date">
        <div class="field-title">Sort by</div>
        <select class="js-date">
            <option value="new">Newest</option>
            <option value="old">Oldest</option>
        </select>
    </div> -->
</div>
</center>

<center>
<div class="filtered-posts">
	<p>Content will be displayed here</p>
</div>
</center>
<?php	
//end filter

// $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;

// $today = date( 'Y-m-d' );
// $customQuery = new WP_Query(
// 	array(
// 		'post_type' => 'book', 
// 		'posts_per_page' => 2,
 		// 'paged' => $paged ,
// 		'date_query' => array(
// 			//set date ranges with strings!
// 			'after' => 'today',
// 			//allow exact matches to be returned
// 			'inclusive'         => true,
// 		),
// 	)
// );
?>


 
<!----end of page-------->
<?php

get_footer();
