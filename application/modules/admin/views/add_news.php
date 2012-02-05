{block name=css}
<link rel="stylesheet" type="text/css" href="{$base_url}assets/style/admin.css" />
{/block}
{block name=script}
<script type="text/javascript">
    {literal}
    $(document).ready(function(){
        $('#cancel').click(function(){
            window.location = '{$base_url}admin/news_management';
        });
    });
    {/literal}
</script>
{/block}
{block name=main_content}

<form id="target" method="post" action="{$base_url}admin/news_management/add_news" class="submit_form">
	<?php t_input('news_title');?>
	<?php t_label('news_content');?>
  <textarea cols="30" rows="10" type="text" id="news_content" name="news_content"><?php echo set_value('news_content');?></textarea>
  <input type="submit" name="r" value="ثبت خبر" />
  <button type="button">لغو عملیات</button>
</form>
{/block}
