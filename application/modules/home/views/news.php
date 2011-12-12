{block name=main_content}

<div class="product">
     <?php foreach ($news as $new): ?>
     <div class="item">
         <div class="item_title"> <?php echo $new['title'];?> </div>
         <div class="description"> <?php echo $new['content']; ?> </div>
    </div>
     <?php endforeach;?>
</div>


{/block}