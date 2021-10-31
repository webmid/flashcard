<?php

use Illuminate\Support\Facades\Validator;

function validateBacktoMenu($data)
{
    $validator = Validator::make([
        'choice' => $data,
    ], [
        'choice' => ['in:-1'],

    ]);
    if ($validator->fails()) {

        return true;
    }
}
