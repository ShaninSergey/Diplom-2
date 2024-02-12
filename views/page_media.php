<?php 

    $this->layout('templates/template_status', ['title' => 'Изменить аватар пользователя']); 
     
?>
  


 <?php $this->start('message') ?>

        <?php if(mb_strlen($this->e($message)) > 0): ?>
            
                <div class="alert alert-success">
                    <?=$this->e($message)?>
                </div>

        <?php endif; ?>

 <?php $this->stop() ?>     




 <?php $this->start('user_data') ?>
 
        <form action="../update_media" method="post"  enctype="multipart/form-data">
            <div class="row">
                <div class="col-xl-6">
                    <div id="panel-1" class="panel">
                        <div class="panel-container">
                            <div class="panel-hdr">
                                <h2>Текущий аватар</h2>
                            </div>
                            <div class="panel-content">
                                <div class="form-group">
                                    <img src="/views/templates/img/demo/avatars/<?= $user['avatar'] ?>" alt="" class="img-responsive" width="200">
                                </div>

                                <div class="form-group">
                                    <label class="form-label" for="example-fileinput">Выберите аватар</label>
                                    <input type="hidden" name="user_id" id="simpleinput" class="form-control" value="<?= $user['user_id'] ?>">
                                    <input type="file"   name="file" id="example-fileinput" class="form-control-file">
                                </div>


                                <div class="col-md-12 mt-3 d-flex flex-row-reverse">
                                    <button class="btn btn-warning">Загрузить</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
 
 <?php $this->stop() ?>   