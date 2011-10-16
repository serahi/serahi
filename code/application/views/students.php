
echo "this page is loaded";

<br/> <hr/>

<?php foreach($m as $row) : ?>
<h1> <?php echo $row->f_name;    ?> </h1>
<?php endforeach ; ?>

