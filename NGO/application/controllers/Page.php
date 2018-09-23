<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Page extends Frontend_Controller {

    function __construct() {
        parent::__construct();

        // Load model
        $this->load->model('public/faq_model');
        $this->load->model('admin/reservation_model');

        // Load library
        $this->load->library('form_validation');
        $this->load->library('usermailer');
        $this->load->library('store');
    }

    /**
     * Show the CMS page.
     * 
     * @param  string $page_url
     * @return void
     */
    public function index($page_url = NULL) {
        $this->cms->get_page($page_url);

        if ($page_url == 'faq')  {
            $this->faq();
            return false;
        }

        if ($page_url == 'contact-us') {
            $this->contact_us();
            return false;
        }

        if($page_url == 'reservation') {
            $this->reservation();
            return false;
        }

        $this->template->build('public/page/index', $this->data);
    }

    /**
     * FAQ page.
     * 
     * @return void
     */
    private function faq() {
        $this->data['faqs'] = $this->faq_model->get_many_by(['status' => 1]);

        $this->template->build('public/page/faq', $this->data);
    }

    /**
     * Show the contact us form.
     * 
     * @return void
     */
    private function contact_us() {
        if ($this->input->post('submit')) {
            $this->form_validation->set_rules('name', 'lang:label.name', 'trim|required');
            $this->form_validation->set_rules('email', 'lang:label.email', 'trim|required|valid_email');
            $this->form_validation->set_rules('phone', 'lang:label.phone', 'trim');
            $this->form_validation->set_rules('message', 'lang:label.message', 'trim|required');

            $this->form_validation->set_error_delimiters('<p class="help-block">', '</p>');

            if ($this->form_validation->run()) {
                $post = $this->input->post(NULL, TRUE);

                // Send email
                if ($this->usermailer->contactUs($post)) {
                    $this->session->set_flashdata('flashdata', array('type' => 'success', 'text' => lang('success_contact_us')));
                } else {
                    $this->session->set_flashdata('flashdata', array('type' => 'error', 'text' => config_item('error_message')));
                }

                redirect(site_url('contact-us'), 'refresh');
                exit();
            }
        }

        $this->data['opening_hours'] = $this->store->openingHours();

        $this->template->build('public/page/contact', $this->data);
    }

    /**
     * Booking table form and actions.
     * 
     * @return void
     */
    public function reservation() {
        if ($this->input->post('submit')) {
            $this->form_validation->set_rules('name', 'lang:label.name', 'trim|required');
            $this->form_validation->set_rules('email', 'lang:label.email', 'trim|required|valid_email');
            $this->form_validation->set_rules('phone', 'lang:label.phone', 'trim|required');
            $this->form_validation->set_rules('booking_date', 'lang:label.booking_date', 'trim|required');
            $this->form_validation->set_rules('booking_time', 'lang:label.booking_time', 'trim|required');
            $this->form_validation->set_rules('party_size', 'lang:label.party_size', 'trim|required|in_list[1,2,3,4,5]');
            $this->form_validation->set_rules('message', 'lang:label.message', 'trim');

            $this->form_validation->set_error_delimiters('<p class="help-block">', '</p>');

            if ($this->form_validation->run()) {
                $post = $this->input->post(NULL, TRUE);

                $this->reservation_model->save($post);

                // Send email
                if ($this->usermailer->bookTable($post)) {
                    $this->session->set_flashdata('flashdata', array('type' => 'success', 'text' => lang('success_reservation')));
                } else {
                    $this->session->set_flashdata('flashdata', array('type' => 'error', 'text' => config_item('error_message')));
                }

                redirect(site_url('reservation'), 'refresh');
                exit();
            }
        }

        $this->template->build('public/page/reservation', $this->data);
    }
}
