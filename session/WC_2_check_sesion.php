<?php

//echo 'file sessin connect';

class SessionChecker {
    /**====================================================================================================================== */
    public function checkSession($redirect_url = '', $should_redirect = true, $error_message = 'Your session is not reliable.') {
        $reliable_session = false;
        
        if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
            // Check if session has not expired and user agent has not changed
            if (isset($_SESSION['user_agent']) && $_SESSION['user_agent'] === $_SERVER['HTTP_USER_AGENT'] &&
                isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity']) < 3600) {
                $reliable_session = true;
                $_SESSION['last_activity'] = time();
            }
        }
        
        if (!$reliable_session && $should_redirect) {
            if (!empty($redirect_url)) {
                header('Location: ' . $redirect_url);
                exit;
            } else {
                echo $error_message;
                exit;
            }
        }
        
        return $reliable_session;
    }

/**====================================================================================================================== */
    /*------------------------------------------check session and create button----------------------------------------------------------------------*/
    public function checkSession_button($should_redirect=false , $redirect_url = '/WC_2_SYS_select_date/WC_2_start.php',  $error_message = 'Your session is not reliable.') {
        $reliable_session = false;
        print_r($_SESSION);
        if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
            // Check if session has not expired and user agent has not changed
            if (isset($_SESSION['user_agent']) && $_SESSION['user_agent'] === $_SERVER['HTTP_USER_AGENT'] &&
                isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity']) < 3600) {
                $reliable_session = true;
                $_SESSION['last_activity'] = time();
            }
        }
    
        if ($reliable_session) {
            return $reliable_session;
        } elseif ($should_redirect) {
            if (!empty($redirect_url)) {
                header('Location: ' . $redirect_url);
                exit;
            }
        } else {
            $root_url = rtrim($_SERVER['DOCUMENT_ROOT'], '/');
            $redirect_url = str_replace($root_url, '', '/');
            $redirect_url = ltrim($redirect_url, '/');
            $redirect_url = '/' . $redirect_url;
    
            echo "<div style='text-align:center; width: 50%; margin: auto;'>";
            echo "<a>".$error_message.'</a><br>';             
            $button_home= '<br><a href="' . $redirect_url . '">Go to homepage</a>';
            echo '<button onclick="window.location.href=\'' . $redirect_url . '\'">' . $button_home . '</button>';
            echo '</div>';
            exit;
        }
    
        return $reliable_session;
    }
    
    /**====================================================================================================================== */
    /**----------------Laravel-----------check session and create button----------------------------------------------------- */
    public function Laravel_checkSession_button($should_redirect = false, $redirect_url = '/WC_2_SYS_select_date/WC_2_start.php', $error_message = 'Your session is not reliable.')
{
    $reliable_session = false;

    if (Auth::check()) {
        // Check if session has not expired and user agent has not changed
        if (Session::get('user_agent') === $_SERVER['HTTP_USER_AGENT'] &&
            (time() - Session::get('last_activity')) < 3600) {
            $reliable_session = true;
            Session::put('last_activity', time());
        }
    }

    if (!$reliable_session && $should_redirect) {
        if (!empty($redirect_url)) {
            return redirect($redirect_url);
        } else {
            $redirect_url = url('/');
            $error_message .= '<br><a href="' . $redirect_url . '">Go to homepage</a>';
            return view('error')->with('error_message', $error_message);
        }
    } elseif (!$reliable_session && !$should_redirect) {
        $redirect_url = url('/');
        $error_message .= '<br><a href="' . $redirect_url . '">Go to homepage</a>';
        return view('error')->with('error_message', $error_message);
    }

    return $reliable_session;
}
/**====================================================================================================================== */



}

?>
