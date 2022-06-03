<?php

namespace phpstan_exstention\ReturnTypeExtensions;

use Administrators;
use ApiKeys;
use BaseApp;
use Customers;
use PhpParser\Node\Expr\MethodCall;
use PHPStan\Analyser\Scope;
use PHPStan\Analyser\SpecifiedTypes;
use PHPStan\Analyser\TypeSpecifierContext;
use PHPStan\Reflection\MethodReflection;
use PHPStan\Type\MethodTypeSpecifyingExtension;
use PHPStan\Type\NullType;
use PHPStan\Type\ObjectType;
use PHPStan\Type\UnionType;

/**
 * Class BaseAppSpecifyType
 * @package phpstan_extensions\ReturnTypeExtensions
 */
class BaseAppSpecifyType implements MethodTypeSpecifyingExtension
{

    /**
     * @return string
     */
    public function getClass(): string
    {
        return BaseApp::class;
    }

    /**
     * @param MethodReflection $methodReflection
     * @param MethodCall $node
     * @param TypeSpecifierContext $context
     * @return bool
     */
    public function isMethodSupported(MethodReflection $methodReflection, MethodCall $node, TypeSpecifierContext $context): bool
    {
        return $methodReflection->getName() === 'isWeb' && !$context->null();
    }

    /**
     * @param MethodReflection $methodReflection
     * @param MethodCall $node
     * @param Scope $scope
     * @param TypeSpecifierContext $context
     * @return SpecifiedTypes
     * @throws \PHPStan\ShouldNotHappenException
     */
    public function specifyTypes(MethodReflection $methodReflection, MethodCall $node, Scope $scope, TypeSpecifierContext $context): SpecifiedTypes
    {

        $methodName = $methodReflection->getName();
        $sureTypes = [];

        //getUser
        $methodCallGetUser = new MethodCall($node->var, 'getUser');
        $exprStringGetUser = (new \PhpParser\PrettyPrinter\Standard())->prettyPrintExpr($methodCallGetUser);
        if ($methodName === 'isApi') {
            $typeGetUser = new UnionType([
                new ObjectType(Administrators::class),
                new ObjectType(Customers::class),
                new ObjectType(ApiKeys::class),
                new NullType()
            ]);
        } else {
            $typeGetUser = new ObjectType(Administrators::class);
        }
        $sureTypes[$exprStringGetUser] = [$methodCallGetUser, $typeGetUser];

        //getCustomer
        $methodCallGetCustomer = new MethodCall($node->var, 'getCustomer');
        $exprStringGetCustomer = (new \PhpParser\PrettyPrinter\Standard())->prettyPrintExpr($methodCallGetCustomer);
        if ($methodName === 'isWeb') {
            $typeGetCustomer = new ObjectType(Customers::class);
        } else {
            $typeGetCustomer = new NullType();
        }
        $sureTypes[$exprStringGetCustomer] = [$methodCallGetCustomer, $typeGetCustomer];
        return new SpecifiedTypes($sureTypes, [], true, []);
    }
}
