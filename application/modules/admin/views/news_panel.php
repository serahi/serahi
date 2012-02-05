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
    <table class="news_table">
        <thead>
            <tr>
                <th><a href="<?php echo base_url();
                        if(isset($_GET['news_sort_by']) && $_GET['news_sort_by'] == 'nTitle' && $_GET['news_type'] == 'asc')
                        {
                            echo "admin/news_management/?news_sort_by=nTitle&news_type=desc";
                        }
                        else
                            echo "admin/news_management/?news_sort_by=nTitle&news_type=asc";?>"/>عنوان خبر</a></th>
                
                <th><a href="<?php echo base_url();
                        if(isset($_GET['news_sort_by']) && $_GET['news_sort_by'] == 'nContent' && $_GET['news_type'] == 'asc')
                        {
                            echo "admin/news_management/?news_sort_by=nContent&news_type=desc";
                        }
                        else
                            echo "admin/news_management/?news_sort_by=nContent&news_type=asc";?>"/>متن خبر</a></th>
                <th><button id="add_news" onclick="add_news();">افزودن خبر</button></th>
            </tr>
        </thead>
        <tbody>

            <?php foreach ($news as $new): ?>
                <tr>
                    <td><?php echo $new['title']; ?></td>
                    <td><?php echo $new['content']; ?></td>
                    <td><a href="<?php echo base_url().'admin/news_management/edit?id=' . $new['id'] ; ?>" > 
                            ویرایش                      
                        </a>
                    </td>
                    
                    <td>
                        <form id="target" method="post" action="<?php echo base_url() . 'admin/news_management/remove_news'; ?> ">
                        <input type="hidden" value="<?php echo $new['id']; ?>" name="news_id"/>
                        <input type="submit" value="حذف"/>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

{/block}

