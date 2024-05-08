<?php

declare(strict_types=1);

namespace EDT\Querying\Conditions;

use EDT\Querying\Contracts\PathsBasedInterface;
use Webmozart\Assert\Assert;

/**
 * @template TCondition of PathsBasedInterface
 *
 * @template-extends AbstractCondition<TCondition>
 * @template-implements ValueDependentConditionInterface<TCondition>
 */
class StartsWith extends AbstractCondition implements ValueDependentConditionInterface
{
    public const OPERATOR = 'STARTS_WITH_CASE_INSENSITIVE';

    public function getOperator(): string
    {
        return self::OPERATOR;
    }

    public function transform(?array $path, mixed $value): PathsBasedInterface
    {
        Assert::notNull($path);
        Assert::string($value);

        return $this->conditionFactory->propertyStartsWithCaseInsensitive($value, $path);
    }
}
