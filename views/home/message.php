<div class="messages">
    <?php
    foreach ($messages as $message):
        if ($message->sender == 0)
            $className = 'admin';
        elseif ($message->receiver == 0)
            $className = 'user';
        else
            continue;
    ?>
    <div class="message <?php echo $className; ?>">
        <div class="message-arrow"></div>
        <div class="message-inner">
            <p class="content"><?php echo $message->message; ?></p>
            <em class="time"><?php echo $message->time; ?></em>
        </div>
    </div>
    <?php endforeach; ?>
</div>
