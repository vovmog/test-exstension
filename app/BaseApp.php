<?php


class BaseApp
{
    /** @var BaseApp|\WebApp|ApiApp the application instance */
    public static $app;

    /** @var bool */
    protected $_isWeb = false;

    /** @var bool */
    protected $_isApi = false;

    public function __construct()
    {
        self::$app = $this;
    }

    public function isWeb(): bool
    {
        return $this->_isWeb;
    }

    public function isApi(): bool
    {
        return $this->_isApi;
    }

    /**
     * @return \Administrators|\ApiKeys|\Customers|null
     */
    public function getUser()
    {
        return null;
    }

    /**
     * @return null
     */
    public function getCustomer()
    {
        return null;
    }
}