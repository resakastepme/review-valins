<?php

if (Session::has('role')) {
    if (time() - Session('attempt') > 43200) {
        Session::flush();
        Auth::logout();
        return redirect()
            ->to('/auth')
            ->with('session-timeout', 'session-timeout')
            ->send();
    }elseif (Session('role') != 0) {
        return redirect()
            ->to('/admin/dashboard')
            ->send();
    }
} else {
    return redirect()->to('/auth')->send();;
}

?>
