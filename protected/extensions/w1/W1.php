<?php

class W1 {

    public $WMI_MERCHANT_ID;
    public $WMI_CURRENCY_ID;
    public $WMI_SUCCESS_URL;
    public $WMI_FAIL_URL;
    public $key;
    private $_params;
    private $url = "https://merchant.w1.ru/checkout/default.aspx";

    /**
     * Конструктор
     */
    public function init() {
        $this->_params = array(){
            'WMI_MERCHANT_ID' => $WMI_MERCHANT_ID,
            'WMI_CURRENCY_ID' => $WMI_CURRENCY_ID,
            'WMI_SUCCESS_URL' => $WMI_SUCCESS_URL,
            'WMI_FAIL_URL' => $WMI_FAIL_URL,
            'WMI_PAYMENT_NO' => rand(0, 9999999),
            'WMI_DESCRIPTION' => 'Покупка прогноза на сайте WinFor.me',
            'WMI_EXPIRED_DATE' => date("Y-m-d H:i:s", time()+86400)
        }
    }

    /**
     * Делает запрос к Api VK
     * @param $method
     * @param $params
     */
    public function pay() {
        
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