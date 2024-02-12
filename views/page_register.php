<?php 
    
    $this->layout('templates/template_register', ['title' => 'Регистрация']); 

?>


<?php $this->start('message') ?>

    <?php if(mb_strlen($this->e($message)) > 0):?>

        <div class="alert alert-danger text-dark" role="alert">
            <?=$this->e($message)?>
        </div>
    <?php endif; ?>
    
<?php $this->stop() ?>     