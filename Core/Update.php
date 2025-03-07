<?php
if (isset($update->message)) {
    $text = $update->message->text;
    $chat_id = $update->message->chat->id;
    $type = $update->message->chat->type;
    $user_id = $update->message->from->id;
}
?>
