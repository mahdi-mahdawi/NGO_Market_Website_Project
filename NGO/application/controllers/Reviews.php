<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Reviews extends Frontend_Controller {

    function __construct() {
        parent::__construct();

        // Load model
        $this->load->model('public/review_model');
        $this->load->model('public/order_model');

        // Load library
        $this->load->library('form_validation');

        $this->cms->get_page('reviews');
    }

    /**
     * Show all the review from the customer.
     * 
     * @return void
     */
    public function index() {
        $this->data['reviews'] = $this->review_model->getAll();

        $this->template->build('public/page/order-reviews', $this->data);
    }

    /**
     * Save new review from the customer.
     * 
     * @return void
     */
    public function save() {
        $review_token = $this->input->get('review_token', true);

        if(empty($review_token)) {
            show_404();
        }

        $order_reference = decode_order_reference($review_token);

        $result = $this->review_model->getReview($order_reference);
        if(!empty($result)) {
            redirect('reviews');
            exit();
        }

        $order = $this->order_model->get_by(['order_reference' => $order_reference]);
        if(empty($order)) {
            redirect('reviews');
            exit();
        }

        // From submitted
        if ($this->input->post('submit')) {
            $this->form_validation->set_rules('comment', 'lang:label.name', 'trim|required|max_length[500]');
            $this->form_validation->set_rules('rating', 'lang:label.email', 'trim|required|in_list[0,1,2,3,4,5]');

            $this->form_validation->set_error_delimiters('<p class="help-block">', '</p>');

            if ($this->form_validation->run()) {
                $post = $this->input->post(NULL, TRUE);
                $timestamp = date('Y-m-d H:i:s');

                $data = [
                    'customer_id' => $order['customer_id'],
                    'order_id'  => $order['order_id'],
                    'rating_value'  => $post['rating'],
                    'comments'  => $post['comment'],
                    'date_created'  => $timestamp,
                    'date_updated'  => $timestamp
                ];

                if($this->review_model->insert($data)) {
                    $this->session->set_flashdata('flashdata', array('type' => 'success', 'text' => lang('success_review_completed')));

                    redirect('reviews');
                    exit();
                }
            }
        }

        $this->data['order'] = $order;
        $this->data['review_token'] = $review_token;

        $this->template->build('public/page/order-review-form', $this->data);
    }
}