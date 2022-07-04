<?php

declare(strict_types=1);

namespace Tests\Querying\Utilities;

use EDT\Querying\ConditionFactories\PhpConditionFactory;
use EDT\Querying\Contracts\ConditionFactoryInterface;
use EDT\Querying\Utilities\PathTransformer;
use PHPUnit\Framework\TestCase;

class PathTransformerTest extends TestCase
{
    /**
     * @var ConditionFactoryInterface
     */
    private $conditionFactory;
    /**
     * @var PathTransformer
     */
    private $pathTransformer;


    protected function setUp(): void
    {
        parent::setUp();
        $this->conditionFactory = new PhpConditionFactory();
        $this->pathTransformer = new PathTransformer();
    }

    public function testPrefixConditionPaths()
    {
        $conditionA = $this->conditionFactory->propertyHasValue('abc', 'x');
        $conditionB = $this->conditionFactory->propertyHasAnyOfValues(['abc'], 'x', 'y');
        $conditionC = $this->conditionFactory->allConditionsApply(
            $this->conditionFactory->propertyIsNull('x', 'y', 'z'),
            $this->conditionFactory->propertyNotBetweenValuesInclusive(1, 3, 'y', 'x')
        );

        $this->pathTransformer->prefixConditionPaths([$conditionA, $conditionB, $conditionC], 'foo', 'bar');

        $pathA = $conditionA->getPropertyPaths()[0]->getAsNames();
        self::assertEquals(['foo', 'bar', 'x'], $pathA);
        $pathB = $conditionB->getPropertyPaths()[0]->getAsNames();
        self::assertEquals(['foo', 'bar', 'x', 'y'], $pathB);
        [$pathC1, $pathC2] = $conditionC->getPropertyPaths();
        self::assertEquals(['foo', 'bar', 'x', 'y', 'z'], $pathC1->getAsNames());
        self::assertEquals(['foo', 'bar', 'y', 'x'], $pathC2->getAsNames());
    }
}