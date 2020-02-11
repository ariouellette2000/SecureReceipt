<!-- Display error messages for the Add Receipts Form -->
<?php if (count($errors) > 0) : ?>
    <div class="isa_error">
        <i class="fa fa-times-circle"></i>
        <?php foreach ($errors as $error) : ?>
            <?php echo $error ?>
        <?php endforeach ?>
    </div>
<?php endif; ?>

<!-- Display success messages for the Add Receipts Form -->
<?php if (count($success) > 0) : ?>
    <div class="isa_success">
        <i class="fa fa-times-circle"></i>
        <?php foreach ($success as $succes) : ?>
            <?php echo $succes ?>
        <?php endforeach ?>
    </div>
<?php endif; ?>
