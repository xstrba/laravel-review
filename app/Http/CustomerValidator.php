<?php

declare(strict_types=1);

namespace App\Http;

use Illuminate\Contracts\Validation\Factory;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

/**
 * class CustomerValidator
 *
 * @package App\Http
 */
final class CustomerValidator
{
    /**
     * @var \Illuminate\Contracts\Validation\Factory
     */
    private $validationFactory;

    public function __construct(Factory $validationFactory)
    {
        $this->validationFactory = $validationFactory;
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return mixed[]
     * @throws \Illuminate\Validation\ValidationException
     */
    public function getValidatedData(Request $request): array
    {
        $required = $request->is(Request::METHOD_POST) ? 'required' : 'sometimes';

        $validator =  $this->validationFactory->make($request->all(),[
            'first_name' => $required . '|string|max:255',
            'last_name' => $required . '|string|max:255',
            'email' => $required . '|string|email|max:255',
            'name' => 'string|max:255',
            'groups' => 'sometimes|array',
            'groups.*' => 'string|max:255',
        ]);

        if($validator->fails()){
            throw new ValidationException($validator);
        }

        // tu si nie som isty ci tam treba 'name'
        return $request->only(['first_name', 'last_name', 'email', 'name']);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return string[]|null
     */
    public function getValidatedGroups(Request $request): ?array
    {
        return $request->get('groups');
    }
}
