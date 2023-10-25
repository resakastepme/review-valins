<?php

if (time() - Session('attempt') > 43200) {
    Session::flush();
    Auth::logout();
    return redirect()
        ->to('/auth')
        ->with('session-timeout', 'session-timeout')
        ->send();
}elseif(!Session('role') == 1){
    return redirect()->to('/user/dashboard')->send();
}

?>
