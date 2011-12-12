<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<rss version="2.0"
	xmlns:content="http://purl.org/rss/1.0/modules/content/"
	xmlns:wfw="http://wellformedweb.org/CommentAPI/"
	xmlns:dc="http://purl.org/dc/elements/1.1/"
	xmlns:atom="http://www.w3.org/2005/Atom"
	xmlns:sy="http://purl.org/rss/1.0/modules/syndication/"
	xmlns:slash="http://purl.org/rss/1.0/modules/slash/"
	>
<channel>
    
    <title>سه‌راهــی</title>
    <link>http://serahi.ir</link>
    <description>خرید گروهی آنلاین</description>
    <language>fa</language>
    <sy:updatePeriod>hourly</sy:updatePeriod>
    <sy:updateFrequency>1</sy:updateFrequency>
    
    
    <?php foreach($posts->result() as $post): ?>
    
    <item>
		<title> <?php echo $post->title ;?> </title>

                <link><?php echo base_url() . 'posts/'. $post->id; ?> </link>;
		<pubDate> <?php echo $post->date; ?> </pubDate>
		<dc:creator> سه‌راهـــی </dc:creator>
		<description> 
                    <?php echo $post->text; ?>
                </description>
		</item>
    <?php endforeach ;?>
    
    
</channel>
    
</rss>