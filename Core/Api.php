<?php
class Telegram
{
    private $token;
    public function __construct($token)
    {
        $this->token = $token;
    }

    private function API($method, $parameters)
    {
        if (!$parameters) {
            $parameters = array();
        }
        $parameters["method"] = $method;
        $handle = curl_init("https://api.telegram.org/bot" . $this->token . "/");
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($handle, CURLOPT_TIMEOUT, 60);
        curl_setopt($handle, CURLOPT_POSTFIELDS, json_encode($parameters));
        curl_setopt($handle, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
        $result = curl_exec($handle);
        return $result;
    }

    public function Send($chat_id, $text, $reply_markup = [], $typeButton = "keyboard")
    {
        $reply_markup = (count($reply_markup) > 0) ? ($typeButton == "keyboard") ? json_encode(['keyboard' => $reply_markup, 'resize_keyboard' => true]) : json_encode(['inline_keyboard' => $reply_markup]) : "" ;

        $this->API("sendMessage", ["chat_id" => $chat_id, "text" => $text, "parse_mode" => "HTML", "reply_markup" => $reply_markup]);
    }
    public function EditMessage($chat_id, $message_id, $text, $reply_markup = [])
    {
        $this->API("editMessageText", ["chat_id" => $chat_id, 'message_id' => $message_id, "text" => $text, "parse_mode" => "HTML"]);
    }
}
