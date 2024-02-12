<?php 
    
    

    $this->layout('templates/template_status', ['title' => 'Изменить статус']); 
    
     
?>
  


 <?php $this->start('message') ?>

        <?php if(mb_strlen($this->e($message)) > 0): ?>
            
                <div class="alert alert-success">
                    <?=$this->e($message)?>
                </div>

        <?php endif; ?>

 <?php $this->stop() ?>     





 <?php $this->start('user_data') ?>
 

        <form action="../update_status" method="post">
            <div class="row">
                <div class="col-xl-6">
                    <div id="panel-1" class="panel">
                        <div class="panel-container">
                            <div class="panel-hdr">
                                <h2>Установка текущего статуса</h2>
                            </div>
                            <div class="panel-content">
                                <div class="row">
                                    <div class="col-md-4">
                                        <!-- status -->
                                        <div class="form-group">
                                            <label class="form-label" for="example-select">Выберите статус</label>
                                            <select class="form-control" name = "status" id="example-select" >
                                                <option value="success" <? if($user['status']=="success") echo "selected";?> >Онлайн</option>
                                                <option value="warning" <? if($user['status']=="warning") echo "selected";?> >Отошел</option>
                                                <option value="danger"  <? if($user['status']=="danger") echo "selected";?> >Не беспокоить</option>
                                            </select>
                                            <input type="hidden" name="id" id="simpleinput" class="form-control" value="<?= $user['id'] ?>">

                                        </div>
                                    </div>
                                    <div class="col-md-12 mt-3 d-flex flex-row-reverse">
                                        <button class="btn btn-warning">Set Status</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </form>



 <?php $this->stop() ?>   