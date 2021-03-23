<form>
    <table>
        <tr>
            <td>
                <label for="price">Price: </label>
            </td>
            <td>
                <input type="text" name="price" id="price" value="<?php echo get_post_meta(get_the_ID(),'price',true); ?>"/>
            </td>
        </tr>
        <tr>
            <td>
                <label for="pdate">Publish date</label>
            </td>
            <td>
                <input type="date" name="pdate" id="pdate" value="<?php echo get_post_meta(get_the_ID(),'pdate',true); ?>"/>
            </td>
        </tr>
    </table>
</form>