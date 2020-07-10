<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Contracts\Validation\Validator;

class Controller extends BaseController
{
    /**
     * {@inheritdoc}
     */
    protected function formatValidationErrors(Validator $validator)
    {
        return [
            'error' => 'PARAMS_ERROR',
            'details' => $validator->errors()->all()
        ];
    }
}
