<!-- Display error message for the registration page -->
<?php if (count($errors) > 0) : ?>
    <div class="isa_error">
        <i class="fa fa-times-circle"></i>
        <?php foreach ($errors as $error) : ?>
            <?php echo $error ?>
        <?php endforeach ?>
    </div>
<?php endif ?>