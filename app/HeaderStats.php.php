<?php

namespace App;

use Illuminate\Support\Facades\Session as Session;

class HeaderStats {

    public function messagesCount() {

        $count = 0;
        $id = Session::get('user_id');
        $token = Session::get('user_data')['auth'];

        $response = \API::get('conversation/user/' . $id, ['Authorization' => $token], ['ID' => $id]);


        if ($response['code'] == 200) {
            
            $conversations = $response["data"];
           
            foreach ($conversations as $conversation) {
                if ($conversation->messages[0]->seen == "0" && $conversation->messages[0]->to_id == $id)
                    $count++;
            }
        }

        return $count;
    }

}
