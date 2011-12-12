{block name=title}
بررسی کد رهگیری
{/block}
{block name=main_content}

<div class="g_form" >
<form action="<?php echo base_url()?>seller/check_pursuit_code" method="post" class="forms submit_form">
    
        <?php
        if(isset($not_found_pc))
        {
            echo '<div class="error_msg">' . $not_found_pc['msg'] . '</div>';
        }
        if (isset($found_pc))
        {
            echo '<div class="ok_msg">' . $found_pc['msg'] . '</div>';
        }
        if(isset($delivered))
        {
            echo '<div class="ok_msg">' . $delivered['msg'] . '</div>';
        }
        if(isset($is_delivered))
        {
            echo '<div class="error_msg">' . $is_delivered['msg'] . '</div>';
        }
        
        ?>
    
    <input type="text" class="check validate[required,minSize[10],maxSize[10]" name="pursuit_code" value="کد رهگیری">
    <input type="submit" class="submit_btm" name="submit"  value="تحویل شد!"/>    
    <input type="submit" class="submit_btm"  name="submit" value="بررسی کن!" />
</form>
    
</div>

{/block}
