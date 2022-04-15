<?php

use Phalcon\Mvc\Controller;


class IndexController extends Controller
{
    public function indexAction()
    {
        $collection = $this->mongo->user;
        $cursor = $collection->find();
        $users = array();
        foreach ($cursor as $res) {
            array_push($users, array(
                'username' => $res->username,
                'name' => $res->name,
                'email' => $res->email
            ));
        };
        $this->view->users = $users;
    }
    public function tryAction()
    {
    }
    public function viewAllProduct()
    {
        $collection = $this->mongo->user;
        $cursor = $collection->find();
        $users = array();
        foreach ($cursor as $res) {
            array_push($users, array(
                'username' => $res->username,
                'name' => $res->name,
                'email' => $res->email
            ));
        };
        $this->view->users = $users;
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
            for($i=0; $i<count($variation_values); $i++){
                array_push($variactions, array(
                    "color"=> $variation_values[$i],
                    "size"=>$variation_values[++$i],
                    "price"=>$variation_values[++$i],
                ));
            }
            $collection = $this->di->get('mongo')->user;
            $insertOneResult = $collection->insertOne([
                "name" => $this->request->getPost('name'),
                "category" => $this->request->getPost('category'),
                "price" => $this->request->getPost('price'),
                "stock" => $this->request->getPost('stock'),
                "additional" => array(
                    "meta_information"=>$meta_information,
                    "variactions"=>$variactions
                )
            ]);
            $this->response->setContent("Product Added Successfully");
        }
    }
    public function addUser()
    {
        $collection = $this->di->get('mongo')->user;
        $insertOneResult = $collection->insertOne([
            'username' => 'admin',
            'email' => 'admin@example.com',
            'name' => 'Admin User',
        ]);
        printf("Inserted %d document(s)\n", $insertOneResult->getInsertedCount());
        var_dump($insertOneResult->getInsertedId());
    }
}
