<?php

class OrderEntity
{
    // t.id, t.order_total, t.orderDate,t.orderStatus, c.id as 'User_id',c.first_name,c.last_name
    protected $id;
    protected $order_total;
    protected $orderDate;
    protected $orderStatus;
    protected $User_id;
    protected $first_name;
    protected $last_name;

    /** 
     * Accept an array of data matching properties of this class
     * and create the class
     *
     * @param array $data The data to use to create
     */
    public function __construct($data=[]) {
         if($data['id']=="") 
            $this->id=""; 
        else
            $this->id=$data['id'];

        $this->order_total = $data['order_total'];
        $this->orderDate = $data['orderDate'];
        $this->orderStatus = $data['orderStatus'];
        $this->User_id = $data['User_id'];
        $this->first_name = $data['first_name'];
        $this->last_name = $data['last_name'];
    }
    public function getOrder() {
         if($this->id=="") 
            return false; 
        return ["id"=>$this->id ,
        "order_total"=>$this->order_total ,
        "orderDate"=>$this->orderDate ,
        "orderStatus"=>$this->orderStatus ,
        "User_id"=> $this->User_id,
        "first_name"=> $this->first_name,
        "last_name"=>$this->last_name ,];

    }

    public function getId() {
        return $this->id;
    }

   
}
