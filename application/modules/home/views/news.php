{block name=main_content}

<div class="product">
     <?php foreach ($news as $new): ?>
     <div class="item">
         <div class="item_title"> <b> <?php echo $new['title'];?> </b> </div>
         <div class="news_date"> <?php echo $new['date'];?> </div>
         <div class="desc"> <?php echo $new['content']; ?> </div>
        
    </div>
     <?php endforeach;?>
</div>


{/block}