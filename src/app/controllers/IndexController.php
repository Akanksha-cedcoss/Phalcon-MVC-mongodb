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
            $variation = $this->request->getPost('variation');
            $variactions = array();
            for($i=0; $i<$variation; $i++) {
                // die('field'.$i.'');
                $fields = $this->request->getPost('fields'.$i.'');
                $values = $this->request->getPost('values'.$i.'');
                // die($fields);
                $var = array();
                foreach($fields as $k=>$v){
                    $var[$v] = $values[$k];
                }
                array_push($variactions, $var);
            }
            $collection = $this->di->get('mongo')->user;
            $insertOneResult = $collection->insertOne([
                "name" => $this->request->getPost('name'),
                "category" => $this->request->getPost('category'),
                "price" => $this->request->getPost('price'),
                "stock" => $this->request->getPost('stock'),
                "additional" => $variactions
            ]);
            printf("Inserted %d document(s)\n", $insertOneResult->getInsertedCount());
            var_dump($insertOneResult->getInsertedId());
            die('this');
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
