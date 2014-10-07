chikka
======

Chikka API class

USAGE
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
