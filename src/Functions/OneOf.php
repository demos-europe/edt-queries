<?php

declare(strict_types=1);

namespace EDT\Querying\Functions;

use function in_array;

/**
 * @template V
 * @template-extends AbstractMultiFunction<bool, list<V>|V, array{list<V>, V}>
 */
class OneOf extends AbstractMultiFunction
{
    protected function reduce(array $functionResults): bool
    {
        [$contains, $contained] = $functionResults;
        return in_array($contained, $contains, true);
    }
}
