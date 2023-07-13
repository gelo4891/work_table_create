<?php
        session_start();

class SessionChecker {
    /*------------------------------------------check session and create button----------------------------------------------------------------------*/
    function WC_Auth_check_session($should_redirect = '', $redirect_url='' ,  $error_message = 'Your session is not reliable11111111.') {

        $reliable_session = false;
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
        }         
        elseif (!empty($redirect_url)) {
            if ($should_redirect) {
                header('Location: ' . $redirect_url);
                exit;
            } else{
                echo "<div style='text-align:center; width: 50%; margin: auto;'>";
                echo "<a>".$error_message.'</a><br>';             
                $button_home= '<br><a href="' . $redirect_url . '">Go to homepage</a>';
                echo '<button onclick="window.location.href=\'' . $redirect_url . '\'">' . $button_home . '</button>';
                echo '</div>';
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
    }

    /**====================================================================================================================== */
    public function checkSession($redirect_url = '', $should_redirect = true, $error_message = 'Your session is not reliable222222.') {
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
   
    
    /**====================================================================================================================== */
    /**----------------Laravel-----------check session and create button----------------------------------------------------- */
    public function Laravel_checkSession_button($should_redirect = false, $redirect_url = '/WC_2_SYS_select_date/WC_2_start.php', $error_message = 'Your session is not reliable33333333.')
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
/*
/*=============================отримання помилок в роботі программи======================================== */
/*
public function session_errorHandler($errno, $errstr, $errfile, $errline) {
    $log_file = $_SERVER['DOCUMENT_ROOT'] . '/error_log/error_log.txt';
    $error_data = date('Y-m-d H:i:s') . " - Помилка: $errstr в файлі $errfile на рядку $errline\n";
    file_put_contents($log_file, $error_data, FILE_APPEND);
    //header("HTTP/1.0 500 Internal Server Error");
    //echo "<html><body><h1>Помилка на сервері</h1><p>Помилка: $errstr в файлі $errfile на рядку $errline</p></body></html>";
}
*/

}

?>
