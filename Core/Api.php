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

    public function Send($chat_id, $text)
    {
        $this->API("sendMessage", ["chat_id" => $chat_id, "text" => $text, "parse_mode" => "HTML"]);
    }
}
