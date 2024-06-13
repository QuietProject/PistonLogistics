<?php
class CustomersView extends Customer
{

    public function fetchAllCustomers()
    {
        return $this->getAllCustomers();
    }

    public function customerExists($rut)
    {
        return $this->existsCustomer($rut);
    }
    public function fetchCustomer($rut){
        return $this->getCustomer($rut);
    }

    public function hayCustomers()
    {
        return $this->customersCount();
    }

}
