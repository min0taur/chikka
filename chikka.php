<?php
/*/ ----------------------
Chikka SMS API
- SEND
    $chikka = new chikka();
    $chikka->message = 'message';
    echo $chikka->_send('09181234567');
-REPLY
    $chikka = new chikka();
    $chikka->message_type  = 'REPLY';
    // pag hindi free set $chikka->request_cost
    $chikka->message = $message;
    echo $chikka->_send();   
// Kung galing sa database set this
 - $chikka->message_id
 - $chikka->mobile_number
*/
Class chikka {
    protected $client_id  = '';
    protected $secret_key = '';
    public $shortcode     = '29290XXX';
    public $message_type  = 'SEND';
    public $request_cost  = 'FREE';
    function __construct()
    {
        $this->message_id = md5(uniqid($this->shortcode, true));
        if( isset($_POST['request_id']) ) $this->request_id = $_POST['request_id'];
        if( isset($_POST['mobile_number']) ) $this->mobile_number = $_POST['mobile_number'];
    }
    /*/ --------------------
    Send chikka SMS
    */
    public function _send($to = '')
    {
        if( $to != '' ) $this->mobile_number = $to;
        $ch = curl_init();
        $fields = array (
            'message_type'  => $this->message_type,
            'mobile_number' => $this->mobile_number,
            'message'       => $this->message,
            'message_id'    => $this->message_id,
            'client_id'     => $this->client_id,
            'secret_key'    => $this->secret_key,
            'shortcode'     => $this->shortcode
        );
        if( $this->message_type == 'REPLY' ) {
            $fields['request_id']   = $this->request_id;
            $fields['request_cost'] = $this->request_cost;
        }

        $postvars = http_build_query($fields);
        //return $postvars;
        $url = 'https://post.chikka.com/smsapi/request';
        curl_setopt($ch,CURLOPT_URL, $url);
        curl_setopt($ch,CURLOPT_POST, count($fields));
        curl_setopt($ch,CURLOPT_POSTFIELDS, $postvars);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch,CURLOPT_CONNECTTIMEOUT ,3);
        curl_setopt($ch,CURLOPT_TIMEOUT, 20);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $response = curl_exec($ch);
        curl_close ($ch);
        $res = json_decode($response);
        return $res->message;
    }
}
