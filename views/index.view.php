<div class="blog-image">
<a id="blog-image" href="<?php echo URL; ?>">
    <img class="text-center" alt="Duy Thien" src="https://image.shutterstock.com/image-vector/chip-isolated-minimal-icon-processor-260nw-1408286816.jpg">
</a>
 <h2 class="text-center" >Here are some articles I've written:</h2>

</div>
<div class="span2"></div>
  <div class="span8">
      <div class="content">
         <?php
         // while ($cursor->hasNext()):
            foreach ($cursor as $document) {
        //$article = $cursor->getNext(); 
        $article = $document;
    ?>
    <h2><?php echo $article['title']; ?></h2>
    <span class="date"><?php echo date('M d/Y H:i',$article['saved_at']); ?> post By <?php echo $name;?></span>

    <p><?php echo substr($article['html'], 0, 200);?></p>
    <a href="single.php?id=<?php echo $article['_id']; ?>">Read more</a>
  <?php 
    //endwhile; 
    }
?>
  </div>
  </div><!-- span8 -->
<div class="span2"></div>
<!-- pagination -->
<div class="row">
    <div class="span12">
        <ul class="pager">
          <li>
            <?php if($currentPage !== 1): ?>
                <a href="<?php echo $_SERVER['PHP_SELF'].'?page='.($currentPage - 1); ?>">&larr; Older</a>
            <?php endif; ?>

          </li>
                    <li lass="page-number"> <?php echo $currentPage; ?> </li>

          <li>
            <?php if($currentPage !== $totalPages): ?>
                <a href="<?php echo $_SERVER['PHP_SELF'].'?page='.($currentPage + 1); ?>">Newer &rarr;</a>
            <?php endif;?>
        </li>
        </ul>
    </div>
</div>
