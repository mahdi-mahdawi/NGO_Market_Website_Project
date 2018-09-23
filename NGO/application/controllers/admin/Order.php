<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Order extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->data['parent'] = 0;
        $this->data['child'] = 25;

        $this->template->title('Order Management');

        // Load library
        $this->load->library('form_validation');
        $this->load->library('usermailer');
        $this->load->library('usersms');

        // Load model
        $this->load->model('public/order_model');
    }

    /**
     * Get all order.
     *
     * @return void
     */
    public function index()
    {
        $this->template->load_asset(array('datatable'));
        
        $this->data['orders'] = $this->order_model->getAllOrders();

        $this->template->build('admin/order/index', $this->data);
    }

   
    /**
     * Show the order details.
     *
     * @param  string $order_reference
     * @return void
     */
    public function view($order_reference = null)
    {
        if (is_null($order_reference) || !is_numeric($order_reference)) {
            show_404();
        }

        $this->data['order'] = transformIndividualOrder($this->order_model->getOrder($order_reference));
        if (empty($this->data['order'])) {
            show_404();
        }

        // Update the order status
        if ($this->input->post('submit')) {
            $this->_update_order_status($this->data['order']['order_status'], $order_reference);
        }

        $this->template->build('admin/order/view', $this->data);
    }

    /**
     * Update the order status.
     *
     * @return boolean
     */
    private function _update_order_status($old_order_status, $order_reference)
    {
        $post = $this->input->post(null, true);

        // No change in order status.
        if ($old_order_status == $post['order_status']) {
            return true;
        }

        $this->order_model->update_by(['order_reference' => $order_reference], ['order_status' => $post['order_status']]);

        // Send email.
        if ($post['order_status'] == 2) {
            $this->usermailer->orderConfirmed($order_reference);
            $this->usersms->orderConfirmed($order_reference);
        } elseif ($post['order_status'] == 3) {
            $this->usermailer->orderCancelled($order_reference);
            $this->usersms->orderCancelled($order_reference);
        } elseif ($post['order_status'] == 4) {
            $this->usermailer->orderDelivered($order_reference);
            $this->usersms->orderDelivered($order_reference);
        }

        redirect('admin/order/view/' . $order_reference);
        exit();
    }

    /**
     * Download PDF receipt for an order.
     *
     * @param  string $order_reference
     * @return void
     */
    public function download_receipt($order_reference = null)
    {
        if (is_null($order_reference) || !is_numeric($order_reference)) {
            show_404();
        }

        $order = transformIndividualOrder($this->order_model->getOrder($order_reference));
        if (empty($order)) {
            show_404();
        }

        $data = [
            'order' => $order,
            'store_name' => $this->global_settings['store_name'],
            'store_phone' => $this->global_settings['store_phone'],
            'store_address' => $this->global_settings['store_address']
        ];

        require_once(APPPATH . 'third_party/tcpdf/tcpdf.php');

        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetAutoPageBreak(true, PDF_MARGIN_BOTTOM);

        $pdf->SetFont('helvetica', '', 9);
        $pdf->AddPage('P', 'A6');

        $html = $this->load->view('pdf/order-receipt', $data, true);
        $pdf->writeHTML($html, true, 0, true, 0);
        $pdf->lastPage();
        $pdf->Output($order_reference . '.pdf', 'I');
    }
}
