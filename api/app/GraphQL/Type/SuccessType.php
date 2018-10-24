<?php

namespace App\GraphQL\Type;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Type as BaseType;

class SuccessType extends BaseType
{
    protected $attributes = [
        'name' => 'SuccessType',
        'description' => 'Resultado de la operacion'
    ];

    public function fields()
    {
        return [
            'success' => [
                'type' => Type::nonNull(Type::boolean()),
                'description' => 'Resultado de la operacion'
            ]
        ];
    }
}
