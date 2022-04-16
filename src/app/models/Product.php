<?php

use Phalcon\Mvc\Model;

class Product extends Model
{
    public $collection;
    /**
     * initializing mongo constructor
     *
     * @return void
     */
    public function initialize()
    {
        $this->collection = $this->di->get("mongo")->product;
    }
    /**
     * add new product to the database
     *
     * @param [type] $product
     * @return void
     */
    public function addNewProduct($product)
    {
        $insertOneResult = $this->collection->insertOne($product);
    }
    /**
     * get product by name from db
     *
     * @param [type] $name
     * @return object
     */
    public function getProductByName($name)
    {
        return $this->collection->find(['name' => $name]);
    }
    /**
     * get all products from db
     *
     * @return object
     */
    public function getAllProducts()
    {
        return $this->collection->find();
    }
    /**
     * delete product by id
     *
     * @param [type] $product_id
     * @return void
     */
    public function deleteProductById($product_id)
    {
        $this->collection->deleteOne(['_id' => new MongoDB\BSON\ObjectID($product_id)]);
    }
    /**
     * get product by id
     *
     * @param [type] $product_id
     * @return object
     */
    public function getProductById($product_id)
    {
        return $this->collection->findOne(['_id' => new MongoDB\BSON\ObjectID($product_id)]);
    }
    /**
     * update product in db
     *
     * @param [type] $product_id
     * @param [type] $updatedData
     * @return void
     */
    public function updateProductById($product_id, $updatedData)
    {
        $updateResult = $this->collection->updateOne(['_id' => new MongoDB\BSON\ObjectID($product_id)], ['$set' => $updatedData]);
    }
}
