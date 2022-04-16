<?php

use Phalcon\Mvc\Model;

class Product extends Model
{
    public $collection;
    public function initialize()
    {
        $this->collection = $this->di->get("mongo")->product;
    }
    public function addNewProduct($product)
    {
        $insertOneResult = $this->collection->insertOne($product);
    }
    public function getProductByName($name)
    {
        return $this->collection->find(['name'=>$name]);
    }
    public function getAllProducts()
    {
        return $this->collection->find();
    }
    public function deleteProductById($product_id)
    {
        $this->collection->deleteOne(['_id' => new MongoDB\BSON\ObjectID($product_id)]);
    }
    public function getProductById($product_id)
    {
        return $this->collection->findOne(['_id' => new MongoDB\BSON\ObjectID($product_id)]);
    }
    public function updateProductById($product_id, $updatedData)
    {
        $updateResult = $this->collection->updateOne(['_id' => new MongoDB\BSON\ObjectID($product_id)], ['$set' => $updatedData]);
    }
}
