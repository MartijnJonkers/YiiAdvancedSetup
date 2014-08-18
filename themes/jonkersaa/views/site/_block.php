<div class="block">
    <div class="box">
        <div class="content <?php echo $imageClass; ?>">

        </div>
    </div>
    <div class="text">
        <div class="title"><?php echo $title; ?></div>
        <hr>
        <?php echo $text; ?>
        <?php echo Language::link( 'read more button',$url,null,array('class'=>'button')); ?>
    </div>
</div>