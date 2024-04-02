<?php
if (!function_exists('static_asset')) {
    /**
     * Generate an asset path for the application.
     *
     * @param string $path
     * @param bool|null $secure
     * @return string
     */

     if (!function_exists('getFileBaseURL')) {
        function getFileBaseURL()
        {
            if (env('FILESYSTEM_DRIVER') == 's3') {
                return env('AWS_URL') . '/';
            } else {
                return getBaseURL() . 'public/';
            }
        }
    }

    if (!function_exists('getBaseURL')) {
        function getBaseURL()
        {
            $root = '//' . $_SERVER['HTTP_HOST'];
            $root .= str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);

            return $root;
        }
    }
    function static_asset($path, $secure = null)
    {
        return app('url')->asset( $path, $secure);
    }
}

?>