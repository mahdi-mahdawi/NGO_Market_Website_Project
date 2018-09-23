<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Ck_uploader extends Admin_Controller {

    function __construct() {
        parent::__construct();
    }

    public function index() {
        $upload_dir = '/uploads/' . $_GET['folder'];

        $imgsets = array(
            'maxsize' => 2000, // maximum file size, in KiloBytes (2 MB)
            'maxwidth' => 900, // maximum allowed width, in pixels
            'maxheight' => 800, // maximum allowed height, in pixels
            'minwidth' => 10, // minimum allowed width, in pixels
            'minheight' => 10, // minimum allowed height, in pixels
            'type' => array('bmp', 'gif', 'jpg', 'jpe', 'png')  // allowed extensions
        );

        $re = '';

        if (isset($_FILES['upload']) && strlen($_FILES['upload']['name']) > 1) {
            $upload_dir = trim($upload_dir, '/') . '/';
            $img_name = basename($_FILES['upload']['name']);

            $protocol = !empty($_SERVER['HTTPS']) ? 'https://' : 'http://';
            $site = $protocol . $_SERVER['SERVER_NAME'] . '/';

            $uploadpath = FCPATH . '/' . $upload_dir . $img_name;
            $sepext = explode('.', strtolower($_FILES['upload']['name']));
            $type = end($sepext);
            list($width, $height) = getimagesize($_FILES['upload']['tmp_name']);
            $err = '';

            if (!in_array($type, $imgsets['type']))
                $err .= 'The file: ' . $_FILES['upload']['name'] . ' has not the allowed extension type.';
            if ($_FILES['upload']['size'] > $imgsets['maxsize'] * 1000)
                $err .= '\\n Maximum file size must be: ' . $imgsets['maxsize'] . ' KB.';
            if (isset($width) && isset($height)) {
                if ($width > $imgsets['maxwidth'] || $height > $imgsets['maxheight'])
                    $err .= '\\n Width x Height = ' . $width . ' x ' . $height . ' \\n The maximum Width x Height must be: ' . $imgsets['maxwidth'] . ' x ' . $imgsets['maxheight'];
                if ($width < $imgsets['minwidth'] || $height < $imgsets['minheight'])
                    $err .= '\\n Width x Height = ' . $width . ' x ' . $height . '\\n The minimum Width x Height must be: ' . $imgsets['minwidth'] . ' x ' . $imgsets['minheight'];
            }

            // If no errors, upload the image, else, output the errors
            if ($err == '') {
                if (move_uploaded_file($_FILES['upload']['tmp_name'], $uploadpath)) {
                    $CKEditorFuncNum = $_GET['CKEditorFuncNum'];
                    $url = base_url() . $upload_dir . $img_name;
                    $message = $img_name . ' successfully uploaded: \\n- Size: ' . number_format($_FILES['upload']['size'] / 1024, 3, '.', '') . ' KB \\n- Image Width x Height: ' . $width . ' x ' . $height;
                    $re = "window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$message')";
                } else
                    $re = 'alert("Unable to upload the file")';
            } else {
                $re = 'alert("' . $err . '")';
            }
        }

        die("<script>$re;</script>");
    }

}
