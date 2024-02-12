<?php 
    
    $this->layout('templates/template_login', ['title' => 'Войти']); 

?>

<?php $this->start('message') ?>

    <?php if(mb_strlen($this->e($message)) > 0):?>
        
            <div class="alert alert-success">
                <?=$this->e($message)?>
            </div>

    <?php endif; ?>

<?php $this->stop() ?>     