<?php

namespace App;

use Illuminate\Support\Facades\Session as Session;

class HeaderStats {

    public function messagesCount() {
        
        $count = 0;
        
        $response = \API::get('conversation/user/' . Session::get('user_id'), ['Authorization' => Session::get('user_data')['auth']], ['ID' => Session::get('user_id')]);

        if ($response['code'] == 200) {
            
            $conversations = $response["data"];
            
            foreach ($conversations as $conversation) {
                if (@$conversation->messages[0]->seen == "0" && @$conversation->messages[0]->to_id == Session::get('user_id'))
                    $count++;
            }
        }

        return $count;
    }

}
