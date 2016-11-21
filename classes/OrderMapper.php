<?php

class OrderMapper extends Mapper
{
       /**
     * Get one order by its ID
     *
     * @param int $order_id The ID of the order
     * @return OrderEntity  The order
     */
    public function getOrderById($order_id) {
        $sql = "SELECT t.id, t.order_total, t.orderDate,t.orderStatus,c.id as User_id, c.first_name,c.last_name
            from orders t
            join users c on (c.id = t.user_id)
            where t.id = :order_id";
        $stmt = $this->db->prepare($sql);
        $result = $stmt->execute(["order_id" => $order_id]);           
        if($result) {

            $obj= new OrderEntity($stmt->fetch());
            return $obj->getOrder();
        }
        return false;

    }




    public function changeStatus($order_id) {
        $order = $this->getOrderById($order_id);
       
        if($order === false)
            return "Order does not exists!";
        if($order['orderStatus']=="2")
           return "Order already canceled";
        $sql = "update orders set orderStatus=2 where  id =:order_id";
        $stmt = $this->db->prepare($sql);
        $result = $stmt->execute(["order_id" => $order_id]);       

        if(!$result) 
           return "Failed!";
        return "Success";
    }
}
