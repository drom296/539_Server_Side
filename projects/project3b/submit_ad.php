<?php
    session_start();
    ob_start();

    require ("LIB_project1.php");

    $captchaLoc = "js/qaptcha/";

    // @formatter:off
    $styles = array("css/pedro.css", "css/nav.css", 
                    "css/form.css", $captchaLoc . "jquery/QapTcha.jquery.css");
    // @formatter:on

    // @formatter:off
    $scripts = array($captchaLoc . "jquery/jquery.js", 
                        $captchaLoc . "jquery/jquery-ui.js", 
                        $captchaLoc . "jquery/jquery.ui.touch.js", 
                        $captchaLoc . "jquery/QapTcha.jquery.js", 
                        'js/pedro_captcha.js');
    // @formatter:on

    // var_dump($scripts);

    // create header tags
    $output = html_header("Submit Your Ad Here", $styles, $scripts);

    // create banner div
    $output .= addBanner();

    // create the nav
    $output .= addNav();

    ////// CONTENT
    $output .= startContentDiv();

    // required fields
    $reqFields = array("editions", "content", 'title');

    // check if they submitted the form
    if (isset($_GET['submit'])) {

        // this works on my localhost but not on gibson
        // i guess i'll comment it out for gibson

        // check if they passed the captcha
        // @formatter:off
        if (isset($_SESSION['qaptcha_key']) && 
            !empty($_SESSION['qaptcha_key'])) {
        // @formatter:on

            $myVar = $_SESSION['qaptcha_key'];
            if (isset($_POST['' . $myVar . '']) && empty($_POST['' . $myVar . ''])) {
                // they did not passed the captcha
                $output .= '<div class="submitAdResponse submitError">Failure: 
                                You must be a human to use this form.</div>';
            } else {
                // they passed the captcha

                // check if they submitted everything
                if (arrayContainsVals($_GET, $reqFields)) {

                    // implode the editions array
                    $_GET['editions'] = implode(",", $_GET['editions']);

                    // start building the post array
                    $post = array();
                    foreach ($reqFields as $field) {
                        $post[$field] = $_GET[$field];
                    }

                    // make the request using MyCurl class
                    $response = submitAd($post);

                    // display the result
                    $output .= '<div class="submitAdResponse">' . $response['output'] . '</div>';

                } else {
                    // they did not pass

                    $output .= '<div class="submitAdResponse submitError">Failed to submit ad. All fields are required.</div>';
                }
            }
        } else {
            // they did not passed the captcha
            $output .= '<div class="submitAdResponse submitError">Failure: You must be a human to use this form.</div>';
        }
        unset($_SESSION['qaptcha_key']);
    }

    $output .= displaySubmitAdForm();

    $output .= closeContentDiv();
    ///// FOOTER

    // create footer
    $output .= html_footer("");

    echo $output;

    ob_flush();
?>