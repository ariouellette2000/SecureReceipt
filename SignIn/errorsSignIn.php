<!-- Display all errors related to the SignIn form -->
<?php if (count($errors) > 0) : ?>
    <?php foreach ($errors as $error) : ?>
        <div class="isa_error">
            <i class="fa fa-times-circle"></i>
            <?php echo $error; ?>
        </div>
    <?php endforeach ?>
<?php endif ?>
