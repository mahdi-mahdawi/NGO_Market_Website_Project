<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Upload extends Admin_Controller {

    public function __construct() {
        parent::__construct();

        // Load library
        $this->load->library('uploader');
    }

    /**
     * Upload the image.
     * 
     * @return JSON.
     */
    public function index() {
        if(!isset($_REQUEST['folder'])) {
            die(json_encode(['status' => 0, 'message' => 'Upload folder param missing.']));
        }

        $folder = $_REQUEST['folder'];

        switch ($folder) {
            case 'product':
                $this->uploader->initialize('uploads/product');
                break;

            case 'category':
                $this->uploader->initialize('uploads/category');
                break;

            case 'cover':
                $this->uploader->initialize('uploads/cover');
                break; 

             case 'favicon':
                $this->uploader->initialize('uploads/favicon');
                break;

            case 'blog':
                $this->uploader->initialize('uploads/blog');
                break;

            default:
                die(json_encode(['status' => 0, 'message' => 'Unknown folder.']));
        }

        // Upload the file
        $result = $this->uploader->upload();

        die(json_encode($result));
    }
}
