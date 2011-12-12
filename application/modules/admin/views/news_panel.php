{block name=title}
مدیریت اخبار
{/block}
{block name=script}

<script type="text/javascript">
    {literal}
   $(document).ready(function(){
       $('#add_news').click(function(){
           window.location = '<?php echo base_url() . "admin/news_management/add";?>';
           $('#target').submit(function(){
               return false;
           }
       );
       }
   );
   });

    {/literal}
</script>

{/block}

{block name=main_content}

<form id="target" method="post" action="<?php echo base_url() . 'admin/news_management/remove_news'; ?> ">
    <table class="news_table">
        <thead>
            <tr>
                <th>عنوان خبر</th>
                <th>متن خبر</th>
                <th><input type="submit" value="حذف"/></th>
                <th><button id="add_news" onclick="add_news();">افزودن خبر</button></th>
            </tr>
        </thead>
        <tbody>

            <?php foreach ($news as $new): ?>
                <tr>
                    <td><?php echo $new['title']; ?></td>
                    <td><?php echo $new['content']; ?></td>
                    <td><input type="checkbox" name="<?php echo $new['id']; ?>" /></td>
                    <td><a href="<?php echo base_url().'admin/news_management/edit?id=' . $new['id'] ; ?>" > 
                            ویرایش                      
                        </a>
                    </td>

                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</form>

{/block}

