<?php

// override core en language system validation or define your own en language validation message
return [
    'required' => 'The :attribute field is required.',
    'unique' => 'The :attribute has already been taken.',
    'email' => 'The :attribute must be a valid email address.',
    'min' => [
        'string' => 'The :attribute must be at least :min characters.',
        'numeric' => 'The :attribute must be at least :min.',
    ],
    'max' => [
        'string' => 'The :attribute must not exceed :max characters.',
        'numeric' => 'The :attribute must not exceed :max.',
    ],
];