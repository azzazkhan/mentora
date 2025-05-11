<?php

namespace App;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class Paginator
{
    /**
     * Create a new class instance.
     *
     * @param  int  $page
     * @param  int  $perPage
     */
    public function __construct(
        public int $page,
        public int $perPage,
    ) {
        //
    }

    /**
     * Create a new class instance from a request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return static
     */
    public static function fromRequest(Request $request): self
    {
        $data = static::validate($request->all());

        return new static($data['page'], $data['perPage']);
    }

    /**
     * Get the validation rules for the pagination parameters.
     *
     * @return array<string, list>
     */
    protected static function rules(): array
    {
        return [
            'page' => ['required', 'integer', 'min:1'],
            'perPage' => ['required', 'integer', 'min:1', 'max:100'],
        ];
    }

    /**
     * Validate the pagination parameters.
     *
     * @param  array<string, int>  $data
     * @return array<string, int>
     */
    protected static function validate(array $data)
    {
        $validator = Validator::make($data, static::rules());

        if ($validator->fails()) {
            return ['page' => 1, 'perPage' => 10];
        }

        return new static($data['page'], $data['perPage']);
    }
}
