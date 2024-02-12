<?php 
    
    

    $this->layout('templates/template_edit', ['title' => 'Редактирование данных пользователя']); 
    
     
?>
  


 <?php $this->start('message') ?>

        <?php if(mb_strlen($this->e($message)) > 0): ?>
            
                <div class="alert alert-success">
                    <?=$this->e($message)?>
                </div>

        <?php endif; ?>

 <?php $this->stop() ?>     





 <?php $this->start('user_data') ?>



            <form action="../update_user_data" method="post">
                <div class="row">
                    <div class="col-xl-6">
                        <div id="panel-1" class="panel">
                            <div class="panel-container">
                                <div class="panel-hdr">
                                    <h2>Общая информация</h2>
                                </div>
                                <div class="panel-content">
                                
                                    <!-- username -->
                                    <div class="form-group">
                                        <label class="form-label" for="simpleinput">Имя</label>
                                        <input type="text" name="name" id="simpleinput" class="form-control" value="<?= $user['name'] ?>">
                                        <input type="hidden" name="id" id="simpleinput" class="form-control" value="<?= $user['id'] ?>">
                                        <input type="hidden" name="user_id" id="simpleinput" class="form-control" value="<?= $user['user_id'] ?>">
                                    </div>

                                    <!-- title -->
                                    <div class="form-group">
                                        <label class="form-label" for="simpleinput">Место работы</label>
                                        <input type="text" name="position" id="simpleinput" class="form-control" value="<?= $user['position'] ?>">
                                    </div>

                                    <!-- tel -->
                                    <div class="form-group">
                                        <label class="form-label" for="simpleinput">Номер телефона</label>
                                        <input type="text" name="phone" id="simpleinput" class="form-control" value="<?= $user['phone'] ?>">
                                    </div>

                                    <!-- address -->
                                    <div class="form-group">
                                        <label class="form-label" for="simpleinput">Адрес</label>
                                        <input type="text" name="address" id="simpleinput" class="form-control" value="<?= $user['address'] ?>">
                                    </div>
                                    <div class="col-md-12 mt-3 d-flex flex-row-reverse">
                                        <button class="btn btn-warning">Редактировать</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>


 <?php $this->stop() ?>   