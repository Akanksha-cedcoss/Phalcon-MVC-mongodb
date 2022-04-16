<?php

use Phalcon\Mvc\Controller;


class ProductController extends Controller
{
    public function viewAllProductsAction()
    {
        $product = new Product;
        $this->view->products = $product->getAllProducts();
    }
    public function editProductAction($product_id)
    {
        $product = new Product;
        $this->view->product = $product->getProductById($product_id);
    }
    public function deleteProductAction($id)
    {
    }
    public function addNewProductAction()
    {
        if ($_POST) {
            $meta_fields = $this->request->getPost('meta_fields');
            $meta_values = $this->request->getPost('meta_values');
            $meta_information = array();
            foreach ($meta_fields as $key => $field) {
                $meta_information[$field] = $meta_values[$key];
            }
            $variactions = array();
            $variation_values = $this->request->getPost('values');
            for ($i = 0; $i < count($variation_values); $i++) {
                array_push($variactions, array(
                    "color" => $variation_values[$i],
                    "size" => $variation_values[++$i],
                    "price" => $variation_values[++$i],
                ));
            }
            $product = new Product;
            $product->addNewProduct(array(
                "name" => $this->request->getPost('name'),
                "category" => $this->request->getPost('category'),
                "price" => $this->request->getPost('price'),
                "stock" => $this->request->getPost('stock'),
                "additional" => array(
                    "meta_information" => $meta_information,
                    "variactions" => $variactions
                )
            ));
            $this->response->setContent("Product Added Successfully");
        }
    }
}
