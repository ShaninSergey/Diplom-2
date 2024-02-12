<?php 

    $this->layout('templates/template_status', ['title' => 'Безопасность']); 
     
?>
  


 <?php $this->start('message') ?>

        <?php if(mb_strlen($this->e($message)) > 0): ?>
            
                <div class="alert alert-success">
                    <?=$this->e($message)?>
                </div>

        <?php endif; ?>

 <?php $this->stop() ?>     




 <?php $this->start('user_data') ?>
 

        <form action="../update_security" method="post">
            <div class="row">
                <div class="col-xl-6">
                    <div id="panel-1" class="panel">
                        <div class="panel-container">
                            <div class="panel-hdr">
                                <h2>Обновление эл. адреса и пароля</h2>
                            </div>
                            <div class="panel-content">
                                <!-- email -->
                                <div class="form-group">
                                    <label class="form-label" for="simpleinput">Email</label>
                                    <input type="text" name = "email" id="simpleinput" class="form-control" value="<?= $user['email'] ?>">
                                    <input type="hidden" name = "id" id="simpleinput" class="form-control" value="<?= $user['id'] ?>">
                                                                   
                                </div>

                               <!-- password -->
                               <div class="form-group">
                                    <label class="form-label"  for="simpleinput">Старый пароль</label>
                                    <input type="password_old" name ="password_old" id="simpleinput" class="form-control">
                                </div>


                                <!-- password -->
                                <div class="form-group">
                                    <label class="form-label" for="simpleinput">Новый пароль</label>
                                    <input type="password_new" name ="password_new" id="simpleinput" class="form-control">
                                </div>

                                <!-- password confirmation-->
                                <div class="form-group">
                                    <label class="form-label" for="simpleinput">Подтверждение нового пароля</label>
                                    <input type="password_ver" name = "password_ver" id="simpleinput" class="form-control">
                                </div>


                                <div class="col-md-12 mt-3 d-flex flex-row-reverse">
                                    <button class="btn btn-warning">Изменить</button>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </form>



 <?php $this->stop() ?>   