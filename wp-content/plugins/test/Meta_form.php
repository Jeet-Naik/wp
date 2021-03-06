<form>
    <label for="price">Price: </label>
    <input type="text" name="price" id="price" value="<?php echo get_post_meta(get_the_ID(),'price',true); ?>"/>
</form>