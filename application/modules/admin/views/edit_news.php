{block name=script}
<script type="text/javascript">
    {literal}
    $(document).ready(function(){
        $('#cancel').click(function(){
            window.location = '<?php echo $base_url?>admin/news_management';
            $('#target').submit(function(){
                return false;
            });
        });
            
    });
    {/literal}
</script>
{/block}
{block name=main_content}
<div class="news_wrapper">
<form id="target" method="post" action="{$base_url}admin/news_management/update" class="forms" >
    <input type="text" id="news_title" class="check" name="news_title" value="<?php echo $new['0']['title']; ?>"  />
    <input type="hidden" name="id" value="<?php echo $new['0']['id'];?>" />
    <textarea cols="30" rows="10" type="text" id="news_content" class="check" name="news_content" value=""  title="متن خبر">
<?php echo $new['0']['content'];?>
    </textarea>
    <input type="submit" name="r" value="اعمال تغییرات" />
    <input type="submit" id="cancel" value="لغو عملیات"  /> 
</form>
</div>
{/block}
