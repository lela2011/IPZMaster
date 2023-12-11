<?php
// checks if empty array filtering function already exists
if(!function_exists('filterEmptyArray')) {
    function filterEmptyArray(?array $input) : array {
        // checks if provided array is null
        if(is_null($input)) return [];

        // removes all empty values from array
        return array_filter($input, fn ($value) => !is_null($value));
    }
}
