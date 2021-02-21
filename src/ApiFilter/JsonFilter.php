<?php
namespace App\ApiFilter;

use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\AbstractContextAwareFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\QueryBuilder;

final class JsonFilter extends AbstractContextAwareFilter
{
    protected function filterProperty(string $property, $value, QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, string $operationName = null)
    {
        if (
            !$this->isPropertyEnabled($property, $resourceClass) ||
            !$this->isPropertyMapped($property, $resourceClass)
        ) {
            return;
        }

        $alias = $queryBuilder->getRootAliases()[0];
        $field = $property;

        if ($this->isPropertyNested($property, $resourceClass)) {
            [$alias, $field] = $this->addJoinsForNestedProperty($property, $alias, $queryBuilder, $queryNameGenerator, $resourceClass);
        }

        $parameterName = $queryNameGenerator->generateParameterName($property);

        $queryBuilder
            ->andWhere(sprintf('JSON_CONTAINS(UPPER(%s.%s), UPPER(:%s)) = 1',$alias, $field, $parameterName))
            ->setParameter($parameterName, $value, Types::JSON);
    }

    public function getDescription(string $resourceClass): array
    {
        if (!$this->properties) {
            return [];
        }

        $description = [];
        foreach ($this->properties as $property => $strategy) {
            $description[$property] = [
                'property' => $property,
                'type' => 'string',
                'required' => false,
                'swagger' => [
                    'description' => 'Filter using a JSON search. Not case-sensitive.',
                    'name' => 'JSON filter',
                    'type' => 'Filter using a JSON search',
                ],
            ];
        }

        return $description;
    }
}