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

// defines the route function
function route($name, $parameters = [], $absolute = true)
{
    // retrieve the app url from the config
    $appUrl = config('app.url');

    // Append app url if absolute path is requested
    if ($absolute) {
        // Add the relative path to the app root url
        $relativePath = app('url')->route($name, $parameters, false);
        $url = $appUrl.$relativePath;
    } else {
        // Keep the default behavior
        $url = app('url')->route($name, $parameters, $absolute);
    }

    return $url;
}

