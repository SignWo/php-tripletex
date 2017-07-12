<?php

namespace zaporylie\Tripletex\Api;

use zaporylie\Tripletex\Model\Order\RequestInvoiceCreate;
use zaporylie\Tripletex\Model\Order\RequestOrderDetails;
use zaporylie\Tripletex\Model\Order\RequestOrderList;
use zaporylie\Tripletex\Resource\Order\InvoiceCreate;
use zaporylie\Tripletex\Resource\Order\OrderCreate;
use zaporylie\Tripletex\Resource\Order\OrderDetails;
use zaporylie\Tripletex\Resource\Order\OrderList;
use zaporylie\Tripletex\Resource\Order\OrderUpdate;
use zaporylie\Tripletex\Tripletex;

class Order
{

    /**
     * @var \zaporylie\Tripletex\Tripletex
     */
    protected $app;

    /**
     * Product constructor.
     *
     * @param \zaporylie\Tripletex\Tripletex $app
     */
    public function __construct(Tripletex $app)
    {
        $this->app = $app;
    }

    /**
     * @param array $options
     *
     * @return \zaporylie\Tripletex\Model\Order\ResponseOrderList
     */
    public function getList(\DateTimeInterface $orderDateFrom, \DateTimeInterface $orderDateTo, $options = [])
    {
        $request = new RequestOrderList();
        $request->setOrderDateFrom($orderDateFrom);
        $request->setOrderDateTo($orderDateTo);
        // @todo: Pass options.
        $resource = new OrderList($this->app);
        return $resource->call($request);
    }

    /**
     * @param $id
     * @param array $options
     *
     * @return \zaporylie\Tripletex\Model\Order\ResponseOrderWrapper
     */
    public function getOrder($id, $options = [])
    {
        $request = new RequestOrderDetails();
        $request->setId($id);
        // @todo: Pass options.
        $resource = new OrderDetails($this->app);
        return $resource->call($request);
    }

    /**
     * @param \zaporylie\Tripletex\Api\Order $order
     *
     * @return \zaporylie\Tripletex\Model\Order\ResponseOrderWrapper
     */
    public function updateOrder(Order $order)
    {
        $resource = new OrderUpdate($this->app);
        return $resource->call($order);
    }

    /**
     * @param \zaporylie\Tripletex\Api\Order $order
     *
     * @return \zaporylie\Tripletex\Model\Order\ResponseOrderWrapper
     */
    public function createOrder(Order $order)
    {
        $resource = new OrderCreate($this->app);
        return $resource->call($order);
    }

    /**
     * @param $orderId
     * @param \DateTimeInterface $invoiceDate
     * @param bool $sendToCustomer
     *
     * @return \zaporylie\Tripletex\Model\Invoice\ResponseInvoiceWrapper
     */
    public function createInvoice($orderId, \DateTimeInterface $invoiceDate, $sendToCustomer = true)
    {
        $request = new RequestInvoiceCreate();
        $request->setOrderId($orderId);
        $request->setInvoiceDate($invoiceDate);
        $request->setSendToCustomer($sendToCustomer);
        $resource = new InvoiceCreate($this->app);
        return $resource->call($request);
    }
}