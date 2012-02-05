{block name=script}
<script type="text/javascript">
    {literal}
    $(document).ready(function(){
        $('#cancel').click(function(){
            window.location = '<?php echo base_url() . "admin/news_management";?>';
            $('#target').submit(function(){
                return false;
            });
        });
            
    });
    {/literal}
</script>
{/block}
{block name=main_content}

<div id="sign_up_form">
<form id="target" method="post" action="<?php echo base_url() . 'admin/news_management/add_news'; ?>" class="forms" >
    <input type="text" id="news_title" class="check" name="news_title" value="عنوان خبر"  />
    <textarea cols="30" rows="10" type="text" id="news_content" class="check" name="news_content" value="متن خبر"  title="متن خبر">متن خبر</textarea>
    <input type="submit" name="r" value="ثبت خبر" />
    <input type="submit" id="cancel" value="لغو عملیات"  />
        
</form>
</div>
{/block}
