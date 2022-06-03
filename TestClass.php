<?php

class TestClass
{
    /** @var string|null */
    public $propOne;
    /** @var string|null */
    public $propTwo;

    /**
     * Broken check types
     * 
     * @return bool
     */
    public function test(): bool
    {
        // Broken check type returned phpstan: Access to an undefined property object::$propTwo.
        $res = WebApp::$app->isWeb() && !empty($this->propOne) && $this->propTwo;
        // Broken type of $this
        \PHPStan\dumpType($this);// phpstan: Dumped type: $this(TestClass) but returned phpstan: Dumped type: object&hasProperty(propOne)
        return $res;
    }

    /**
     * Correctly check types
     *
     * @return bool
     */
    public function test1(): bool
    {
        $res = WebApp::$app->isWeb() && empty($this->propOne) && $this->propTwo;        
        \PHPStan\dumpType($this);// phpstan: Dumped type: $this(TestClass)
        return $res;
    }

//    public function test2(): void
//    {
//        if (BaseApp::$app->isWeb()) {
//            $customer = BaseApp::$app->getCustomer();
//            \PHPStan\dumpType($customer); //phpstan: Dumped type: Customers
//        }
//        if (BaseApp::$app->isWeb()) {
//            $user = BaseApp::$app->getUser();
//            \PHPStan\dumpType($user); // phpstan: Dumped type: Administrators
//        }
//    }
//
//    public function test3(): void
//    {
//        if (BaseApp::$app->isApi()) {
//            $user = BaseApp::$app->getUser();
//            \PHPStan\dumpType($user); // phpstan: Dumped type: Administrators|ApiKeys|Customers|null
//
//        }
//    }
//
//    public function test4(): void
//    {
//        if (BaseApp::$app->isApi()) {
//            $customer = BaseApp::$app->getCustomer();
//            \PHPStan\dumpType($customer); //phpstan: Dumped type: null
//        }
//    }
}