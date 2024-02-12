<?php 
    
    $this->layout('templates/template_users', ['title' => 'Пользователи']); 
    
?>
  
 <?php $this->start('message') ?>

        <?php if(mb_strlen($this->e($message)) > 0): ?>
            
                <div class="alert alert-success">
                    <?=$this->e($message)?>
                </div>

        <?php endif; ?>

 <?php $this->stop() ?>     



 <?php $this->start('button') ?>
    
    <?php if($admin == true): ?>
        <a class="btn btn-success" href="in_create_user_page">Добавить</a>
    <?php endif; ?>
   
 <?php $this->stop() ?>     




 <?php $this->start('users') ?>
      
      <?php foreach($users as $user): ?>

            <div class="col-xl-4">
                    <div id="c_1" class="card border shadow-0 mb-g shadow-sm-hover" data-filter-tags="oliver kopyov">
                        <div class="card-body border-faded border-top-0 border-left-0 border-right-0 rounded-top">
                            <div class="d-flex flex-row align-items-center">
                                <span class="status status-<?= $user['status'] ?> mr-3">
                                    <span class="rounded-circle profile-image d-block " style="background-image:url('/views/templates/img/demo/avatars/<?= $user['avatar'] ?>'); background-size: cover;"></span>
                                </span>
                                <div class="info-card-text flex-1">
                                    
                               
                                   <?php if($admin == true || $user['user_id'] == $userID): ?>
                                        
                                        <a href="javascript:void(0);" class="fs-xl text-truncate text-truncate-lg text-info" data-toggle="dropdown" aria-expanded="false">
                                            <?= $user['name'] ?>
                                            
                                                <i class="fal fas fa-cog fa-fw d-inline-block ml-1 fs-md"></i>
                                                <i class="fal fa-angle-down d-inline-block ml-1 fs-md"></i>
                                            
                                        </a>

                                    <?php else: ?>
                                        <?= $user['name'] ?>
                                    <?php endif; ?>

                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="/profile/<?= $user['user_id'] ?>">
                                            <i class="fa fa-edit"></i>
                                        Профиль</a>                                        
                                        
                                        <a class="dropdown-item" href="/edit/<?= $user['user_id'] ?>">
                                            <i class="fa fa-edit"></i>
                                        Редактировать</a>
                                        <a class="dropdown-item" href="/security/<?= $user['user_id'] ?>">
                                            <i class="fa fa-lock"></i>
                                        Безопасность</a>
                                        <a class="dropdown-item" href="/status/<?= $user['user_id'] ?>">
                                            <i class="fa fa-sun"></i>
                                        Установить статус</a>
                                        <a class="dropdown-item" href="/media/<?= $user['user_id'] ?>">
                                            <i class="fa fa-camera"></i>
                                            Загрузить аватар
                                        </a>
                                        <a href="/delit/<?= $user['user_id'] ?>" class="dropdown-item" onclick="return confirm('are you sure?');">
                                            <i class="fa fa-window-close"></i>
                                            Удалить
                                        </a>
                                    </div>
                                    
                                    <span class="text-truncate text-truncate-xl"><?= $user['position'] ?></span>
                                </div>
                                <button class="js-expand-btn btn btn-sm btn-default d-none" data-toggle="collapse" data-target="#c_1 > .card-body + .card-body" aria-expanded="false">
                                    <span class="collapsed-hidden">+</span>
                                    <span class="collapsed-reveal">-</span>
                                </button>
                            </div>
                        </div>
                        <div class="card-body p-0 collapse show">      
                            <div class="p-3">
                                <a href="<?= trim(trim($user['phone'],'-'),' ') ?>" class="mt-1 d-block fs-sm fw-400 text-dark">
                                    <i class="fas fa-mobile-alt text-muted mr-2"></i> <?= $user['phone'] ?></a>
                                <a href="mailto:<?= $user['email'] ?>" class="mt-1 d-block fs-sm fw-400 text-dark">
                                    <i class="fas fa-mouse-pointer text-muted mr-2"></i> <?= $user['email'] ?></a>
                                <address class="fs-sm fw-400 mt-4 text-muted">
                                    <i class="fas fa-map-pin mr-2"></i> <?= $user['address'] ?> </address>
                                <div class="d-flex flex-row">
                                    <a href="javascript:void(0);" class="mr-2 fs-xxl" style="color:#4680C2">
                                        <i class="fab fa-vk"></i>
                                    </a>
                                    <a href="javascript:void(0);" class="mr-2 fs-xxl" style="color:#38A1F3">
                                        <i class="fab fa-telegram"></i>
                                    </a>
                                    <a href="javascript:void(0);" class="mr-2 fs-xxl" style="color:#E1306C">
                                        <i class="fab fa-instagram"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

      <?php endforeach; ?>  

 <?php $this->stop() ?>  
