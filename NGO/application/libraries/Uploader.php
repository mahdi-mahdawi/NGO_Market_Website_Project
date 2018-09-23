<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Uploader {

    /**
     * Upload destination folder.
     * @var string
     */
    private $destination_folder = '';

    /**
     * All file extensions.
     * @var array
     */
    private $file_extensions = [
        'image'     => 'gif|jpg|jpeg|png|GIF|JPG|JPEG|PNG'
    ];

    /**
     * Thumbnail destination folder.
     * @var string
     */
    private $destination_thumb_folder = null;

    /**
     * Upload allowed file extensions for each media types.
     * @var string
     */
    private $allowed_file_extension = '';

    /**
     * Encrypt the filename.
     * @var boolean
     */
    private $encrypt_name = TRUE;

    public function __get($var) {
        return get_instance()->$var;
    }

    /**
     * Initialize the uploader params.
     * 
     * @param  string $media_type
     * @param  string $destination_folder
     * @return new Uploader
     */
    public function initialize($destination_folder) {
        $this->destination_folder       = $destination_folder;
        $this->allowed_file_extension   = $this->file_extensions['image'];
        $this->destination_thumb_folder = $this->destination_folder . '/thumbs';

        return $this;
    }

    /**
     * Upload the file and return the response.
     * 
     * @return new StdClass
     */
    public function upload() {
        $config['upload_path']      = FCPATH . $this->destination_folder . '/';
        $config['allowed_types']    = $this->allowed_file_extension;
        $config['max_size']         = '30000';

        if($this->encrypt_name) {
            $config['encrypt_name']     = TRUE;
            $config['file_name']        = uniqid() . md5(time());
        }
        
        $this->load->library('upload', $config);

        $response  = new StdClass;

        // Do upload
        if ($this->upload->do_upload('file')) {
            $data = $this->upload->data();

            // Resize image
            $this->resizeImage($data['full_path']);

            $response->name         = $data['file_name'];
            $response->size         = (float) $data['file_size'] * 1024;
            $response->type         = $data['file_type'];
            $response->location     = '/' . $this->destination_folder . '/' . $data['file_name'];
            $response->thumbnail    = base_url($this->destination_folder . '/thumbs/' . $data['file_name']);
            $response->file         = base_url($this->destination_folder) . '/' . $data['file_name'];
            $response->error        = null;
            $response->status       = true;
        }else {
            
            $response->error    = $this->upload->display_errors('', '');
            $response->status   = false;
        }

        return $response;
    }

    /**
     * Resize the image.
     * 
     * @param  string $source_image
     * @return void
     */
    private function resizeImage($source_image) {
        $config['image_library']    = 'gd2';
        $config['source_image']     = $source_image;
        $config['new_image']        = $this->destination_thumb_folder;
        $config['create_thumb']     = TRUE;
        $config['maintain_ratio']   = TRUE;
        $config['width']            = 300;
        $config['height']           = 200;
        $config['thumb_marker']     = '';

        $this->load->library('image_lib', $config); 

        $this->image_lib->resize();
    }
}