<?php echo '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL; ?>
<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">

  <channel>
    <title><?php echo '' ?></title>
    <link><?php echo '' ?> </link>
    <description><?php echo '' ?></description>
    <copyright>ivan</copyright>
    <atom:link href="<?php echo '$rssUrl'; ?>" rel="self" type="application/rss+xml"/>
    <?php if (!empty($items)) { ?>
      <?php foreach ($items as $val) { ?>
        <item>
          <title><?php echo $val['title'] ?></title>
          <link><?php echo $val['link'] ?></link>
          <guid><?php echo $val['link'] ?></guid>
          <description><?php echo $val['description']; ?></description>
          <pubDate><?php echo $val['pubDate'] ?></pubDate>
        </item>
      <?php } ?>
    <?php } ?>
  </channel>
</rss>