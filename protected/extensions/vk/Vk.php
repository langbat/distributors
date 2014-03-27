<?php

class Vk {

    public $access_tk;
    public $app_id;
    public $key;
    public $user_id;
    public $group_id;
    private $url = "https://api.vk.com/method/";

    /**
     * Конструктор
     */
    public function init() {

    }

    /**
     * Делает запрос к Api VK
     * @param $method
     * @param $params
     */
    public function method($method, $message, $url = false) {
        $params = array(
            'owner_id' => '-'.$this->group_id,
            'from_group' => '1',
            'message' => $message
        );
        if ($url){
            $params['attachments'] = $url;
        }

        $p = "";
        if( $params && is_array($params) ) {
            foreach($params as $key => $param) {
                $p .= ($p == "" ? "" : "&") . $key . "=" . urlencode($param);
            }
        }
        $response = file_get_contents($this->url . $method . "?" . ($p ? $p . "&" : "") . "access_token=" . $this->access_tk);

        if( $response ) {
            return json_decode($response);
        }
        return false;
    }
}