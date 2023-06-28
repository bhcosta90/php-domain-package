<?php

declare(strict_types=1);

namespace BRCas\CA\Validation;

use Rakit\Validation\Validator;

class RakitValidation
{
    public static function validate($data, $rules): array
    {
        $errors = [];
        $validation = (new Validator())->validate($data, $rules);

        if ($validation->fails()) {
            foreach ($validation->errors()->all() as $error) {
                array_push($errors, $error);
            }
        }

        return $errors;
    }
}
