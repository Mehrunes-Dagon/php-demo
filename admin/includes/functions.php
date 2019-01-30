<?php
function prepare_data($raw_data) {
    switch (gettype($raw_data)) {
        case "string":
            $trimmed_str = trim($raw_data);
            $filtered_email = filter_var($trimmed_str, FILTER_VALIDATE_EMAIL);
            if ($filtered_email) {
                return $filtered_email;
            } else {
                $filtered_str = filter_var($trimmed_str, FILTER_SANITIZE_STRING);
                return $filtered_str;
            }
        case "integer":
            $trimmed_int = trim($raw_data);
            $filtered_int = filter_var($trimmed_int, FILTER_SANITIZE_INT);
            return $filtered_int;
        default:
            echo "Something very strange has happened";
            break;
    }
}

function hash_password($password) {          
    return md5($password);
}

function handle_image($clean_image) {
    $clean_image_tmp = $_FILES['image']['tmp_name'];
    move_uploaded_file($clean_image_tmp, "images/$clean_image");
}

function redirect_page($page) {   
    header("Location: {$page}");  
}

function store_message_in_session($message) {   
    if(empty($message)){ 
        $message = "";
    }else{   
        $_SESSION['message'] = $message;
    }
}

function display_session_message() {
    if(isset($_SESSION['message'])) {    
        echo $_SESSION['message'];     
        unset($_SESSION['message']);     
    }   
}

function alert_message($message, $type) {
    return "
        <div class='alert " . $type . " text-center'>
            <a class='close' href='#'  data-dismiss='alert' aria-label='close'>&times;</a>" 
            . $message . "
        </div>";
    
}
?>



