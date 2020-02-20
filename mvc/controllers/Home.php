<?php

class Home extends Controller {
    function sayHi() {
        $customer = $this->model("Customer");
        $listCustomer = $customer->getAllCustomer();
        $view = $this->view("clothes", ["customers"=>$listCustomer]);
    }

    function show() {
        $company = $this->model("Company");
        $listCompany = $company->all();
        return var_dump($listCompany);
    }
}