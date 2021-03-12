<?php
/*
Template Name: Book list
*/
get_header();

//Filter
?>
<center>
<?php if( get_field('template_header_content') ): ?>
    <p><?php the_field('template_header_content'); ?></p>
<?php endif; ?>
<br/>
<br/>

<div class="flexslider">
    <ul class="slides">
    <?php
    $rows = get_field('slide');
	// echo "<pre>";
	// print_r($rows);
	// echo "</pre>";
	// die;
    if($rows) {
	
        foreach($rows as $row) {
            // retrieve size 'large' for background image
			// echo "<pre>";
			// print_r($row);
			// echo "</pre>";
			// die;
			// $bgimg = $row&#91;'bg_image'&#93;&#91;'sizes'&#93;&#91;'large'&#93;;
			$bgimg =$row['bg_image']['sizes']['large'];
 
            $output = "<li style='background-image: url(". $bgimg .");'>\n";
            $output .= "  <div class='slide-text'>\n";
            // $output .= "  <h2>". $row['slide_heading'] ."</h2>\n";
            // $output .= "  " . $row['slide_text'];
            $output .= "  </div>\n";
            $output .= "</li>\r\n\n";
 
            echo $output;
        }
    }
    ?>
    </ul>
</div>


<div class="filter-wrap">
    <div class="category">
      
        <label>Select category: </label>
            <?php $get_categories = get_categories( array( 'taxonomy'=>'book_category' ) ); ?>
            <select class="js-category">
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
            <br/><br/>
		<label>Select Price order: </label>
		<select name="price_srt" id="price_src">
			<option value="default">Default</option>
			<option value="ASC">Low to High</option>
			<option value="DESC">High to Low</option>
		</select>
		<br/><br/>
		<button  name="submit" id="filter">Filter</button>
    </div>
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
