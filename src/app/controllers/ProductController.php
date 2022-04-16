<?php

use Phalcon\Mvc\Controller;


class ProductController extends Controller
{
    public function viewAllProductsAction()
    {
        $Product = new Product;

        if ($_POST) {
            $name = $this->request->getPost("search");
            $this->view->products = $Product->getProductByName($name);
        } else {
            $this->view->products = $Product->getAllProducts();
        }
    }
    public function filterFormData($post)
    {
        $meta_fields = $post['meta_fields'];
        $meta_values = $post['meta_values'];
        $meta_information = array();
        foreach ($meta_fields as $key => $field) {
            $meta_information[$field] = $meta_values[$key];
        }
        $variation = $post['variation'];
        $variactions = array();
        for ($i = 0; $i < $variation; $i++) {
            $fields = $post['fields' . $i . ''];
            $values = $post['values' . $i . ''];
            $var = array();
            foreach ($fields as $k => $v) {
                $var[$v] = $values[$k];
            }
            array_push($variactions, $var);
        }
        $product = array(
            "name" => $post['name'],
            "category" => $post['category'],
            "price" => $post['price'],
            "stock" => $post['stock'],
            "additional" => array(
                "meta_information" => $meta_information,
                "variations" => $variactions
            )
        );
        return $product;
    }
    public function editProductAction($product_id)
    {
        $product = new Product;
        $this->view->product = $product->getProductById($product_id);
        if ($_POST) {
            $Product = $this->filterFormData($this->request->getPost());
            $product = new Product;
            $product->updateProductById($product_id, $Product);
            $this->response->redirect("product/viewAllProducts");
        }
    }
    public function deleteProductAction($id)
    {
        $product = new Product;
        $product->deleteProductById($id);
        $this->response->redirect("product/viewAllProducts");
    }
    public function addNewProductAction()
    {
        if ($_POST) {
            $Product = $this->filterFormData($this->request->getPost());
            $product = new Product;
            $product->addNewProduct($Product);
            $this->response->redirect("product/viewAllProducts");
        }
    }
    public function getProductAdditionalDataAction()
    {
        if ($this->request->isAjax()) {
            $id = $this->request->getPost('product_id');
            $Product = new Product;
            $product = $Product->getProductById($id);
            return json_encode($product->additional);
        }
    }
}
