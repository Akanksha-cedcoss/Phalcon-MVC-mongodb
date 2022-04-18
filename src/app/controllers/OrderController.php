<?php

use Phalcon\Mvc\Controller;


class OrderController extends Controller
{
    /**
     * view all products
     *
     * @return void
     */
    public function viewAllOrdersAction()
    {
        $Order = new Order;
        if ($_POST) {
            $status = $this->request->getPost("status");
            $date = $this->request->getPost("date");
            if ($status == 'all' and $date == 'all') {
                $this->view->orders = $Order->getAllOrders();
            } else if ($date !== 'all') {
                switch ($date) {
                    case 'today':
                        $start_date = "today";
                        $end_date = "now";
                        break;
                    case 'this week':
                        $start_date = "last monday";
                        $end_date = "now";
                        break;
                    case 'this month':
                        $start_date = "first day of this month";
                        $end_date = "now";
                        break;
                    case 'custom':
                        $start_date = $this->request->getPost("start_date");
                        $end_date = $this->request->getPost("end_date");
                        break;
                } if($status == 'all'){
                    $this->view->orders = $Order->getOrdersByDate($start_date, $end_date);
                } else {
                    $this->view->orders = $Order->getOrdersByDate($status, $start_date, $end_date);
                }
                
            } else {
                $this->view->orders = $Order->getOrdersByStatus($status);
            }
        } else {
            $this->view->orders = $Order->getAllOrders();
        }
    }
    public function addNewOrderAction()
    {
        $Product = new Product;
        $this->view->product = $Product->getAllProducts();
        if ($_POST) {
            $product = $this->request->getPost();
            $product['status'] = "paid";
            $product['order_date'] = new MongoDB\BSON\UTCDateTime(new \DateTimeImmutable(date("Y-m-d H:i:s")));
            $order = new Order();
            $order->addNewOrder($product);
        }
    }
    public function editOrderStatusAction()
    {
        if ($this->request->isAjax()) {
            $id = $this->request->getPost('order_id');
            $status = $this->request->getPost('status');
            $Order = new Order;
            $Order->editOrderStatusById($id, $status);
            // return json_encode($product->additional);
        }
    }
}
