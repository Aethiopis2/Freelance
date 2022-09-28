<!-- display notification message -->
<?php if(count($messages) > 0): ?>
    <div id="message-block">
        <?php foreach($messages as $message): ?>
            <div><?php echo $message; ?></div>
        <?php endforeach ?>
    </div>                            
<?php endif ?>

<!-- display any errors -->
<?php if(count($errors) > 0): ?>
    <div id="error-block">
        <?php foreach($errors as $error): ?>
            <div><?php echo $error; ?></div>
        <?php endforeach ?>
    </div>                            
<?php endif ?>