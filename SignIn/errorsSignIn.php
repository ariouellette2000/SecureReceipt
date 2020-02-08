<?php  if (count($errors) > 0) : ?>
        <?php foreach ($errors as $error) : ?>
                    <div class="isa_error" >
                        <i class="fa fa-times-circle"></i>
                        <?php echo $error; ?>
                    </div>
            <?php if($error === 'Password is invalid. ') :?>
                <?php $_COOKIE['invalidPW'] = 'true' ?>
            <?php  endif ?>
        <?php endforeach ?>
<?php  endif ?>
