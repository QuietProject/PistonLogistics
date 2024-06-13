<?php
class DepotView extends Depot
{

    public function fetchOwnDepots()
    {
        return $this->getOwnDepots();
    }
    public function fetchClientDepots()
    {
        return $this->getClientDepots();
    }

    public function fetchDepot($id){
        return $this->getDepot($id);
    }

    public function depotExists($id)
    {
        return $this->existsDepot($id);
    }

    public function isCustomer($id)
    {
        return $this->customerIs($id);
    }

    public function isOwn($id)
    {
        return $this->ownIs($id);
    }
}
