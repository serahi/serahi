
 {block name=main_content}


  <div id="cm_wrapper">
        <div id="cm_form">
            <form id="edit" method="post" action="{$base_url}product/product/save_edit_comment" class="forms" >
                <textarea cols="50" rows="7" type="text" id="comment_content" class="check" name="comment_content" value="نظر دهید ..."  title=""></textarea>
                <input type="hidden" value="{$comment['id']}" name="comment_id">
                <input type="submit" name="s" value="ذخیره" />

            </form>
        </div>
        
        {/block}