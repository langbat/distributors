<?php

/*
*
*   Переделаный клас от SMS.ru для работы с SMS Aero
*
*/

class Sms extends CApplicationComponent
{
    const HOST  = 'http://gate.smsaero.ru/';
    const SEND = 'send?';
    const STATUS = 'status?';
    const COST = 'cost?';
    const BALANCE = 'my/balance?';
    const LIMIT = 'my/limit?';
    const SENDERS = 'my/senders?';
    const GET_TOKEN = 'auth/get_token';
    const CHECK = 'auth/check?';

    public $login;
    public $password;
    public $token;
    public $id;
    public $md5;
    
    /**
     * Init
     * 
     * @throws CException
     */
    public function init()
    {
        if (!function_exists ('curl_init'))
        {
            throw new CException ('Для работы расширения требуется cURL');
        }

        parent::init();
    }
    
    /**
     * Send message
     * 
     * @param string $to 
     * @param string $text 
     * @param string $from 
     * @param integer $date 
     * @param boolean $test 
     * @param type $partner_id 
     * @return array
     */
    public function send($to, $text, $from = 'WinForMe', $date = null)
    {
        $url = self::HOST . self::SEND;
        $this->id = null;

        $params = $this->get_default_params();
        $params['to'] = $to;
        $params['text'] = $text;

        if ($from)
            $params['from'] = $from;

        if ($date && $date < (time() + 7 * 60 * 60 * 24))
            $params['date'] = $date;

        $result = $this->request($url, $params);
        $result = explode("\n", $result);

        return $result;
    }
    
    /**
     * Check user auth
     * 
     * @return type
     */
    public function check() 
    {
        $url = self::HOST . self::CHECK;
        $params = $this->get_default_params();
        $result = $this->request($url, $params);

        return $result;
    }
    
    protected function get_default_params() 
    {
        return array(
            'user' => $this->login,
            'password' => md5($this->password)
        );
    }
    
    protected function get_md5() 
    {
        $this->md5 = hash('md5', $this->password);
    }
    
    protected function request($url, $params = array()) 
    {
        $ch = curl_init($url);
        $options = array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_POSTFIELDS => $params
        );
        curl_setopt_array($ch, $options);
        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }
}