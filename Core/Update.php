<?php
if (isset($update->message)) {
    @$text = $update->message->text;
    @$chat_id = $update->message->chat->id;
    @$type = $update->message->chat->type;
    @$user_id = $update->message->from->id;
} elseif (isset($update->callback_query)) {
    @$callback_query = $update->callback_query;
    @$callback_query_data = $callback_query->data;
    @$chat_id = $callback_query->message->chat->id;
    @$user_id = $callback_query->from->id;
    @$message_id = $callback_query->message->message_id;
    @$cbq_callback_id = $callback_query->id;
}
?>
