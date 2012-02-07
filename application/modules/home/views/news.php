{block name=main_content}

<div class="news_wrapper">
    <?php foreach ($news as $new): ?>
        <div class="news_item">
            <div class="title"> <b> <?php echo $new['title']; ?> </b> </div>
            <div class="news_date"> <?php echo $new['date']; ?> </div>
            <div class="news_content"> <?php echo $new['content']; ?> </div>

        </div>
    <?php endforeach; ?>
</div>


{/block}