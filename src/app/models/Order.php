<?php

use Phalcon\Mvc\Model;

class Order extends Model
{
    public $collection;
    /**
     * initializing mongo constructor
     *
     * @return void
     */
    public function initialize()
    {
        $this->collection = $this->di->get("mongo")->orders;
    }
    /**
     * get all orders from db
     *
     * @return object
     */
    public function getAllOrders()
    {
        return $this->collection->find();
    }
    /**
     * add new order to db
     *
     * @param [type] $order
     * @return void
     */
    public function addNewOrder($order)
    {
        $this->collection->insertOne($order);
    }
    /**
     * get order by status
     *
     * @param [type] $status
     * @return void
     */
    public function getOrdersByStatus($status)
    {
        return $this->collection->find(['status' => $status]);
    }
    public function editOrderStatusById($order_id, $status)
    {
        $this->collection->updateOne(['_id' => new MongoDB\BSON\ObjectID($order_id)], ['$set' => ['status' => $status]]);
    }
    public function getOrdersByDate($start_date, $end_date)
    {
        return $this->collection->find(['order_date' => ['$gt' => new MongoDB\BSON\UTCDateTime(new \DateTimeImmutable(date("Y-m-d H:i:s", strtotime($start_date)))), '$lt' => new MongoDB\BSON\UTCDateTime(new \DateTimeImmutable(date("Y-m-d H:i:s", strtotime($end_date))))]]);
    }
    public function getOrdersByStatusAndDate($status, $start_date, $end_date)
    {
        return $this->collection->find(['status' => $status, 'order_date' => ['$gt' => new MongoDB\BSON\UTCDateTime(new \DateTimeImmutable(date("Y-m-d H:i:s", strtotime($start_date)))), '$lt' => new MongoDB\BSON\UTCDateTime(new \DateTimeImmutable(date("Y-m-d H:i:s", strtotime($end_date))))]]);
    }
}
