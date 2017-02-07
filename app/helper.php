<?php
use App\Utils\Factory;

if (! function_exists('session')) {
    function session($key = null, $default = null)
    {
        $session = Factory::session();
        if (is_null($key)) {
            return $session;
        }

        if (is_array($key)) {
            $session->set(...$key);
            return $session->get($key[0]);
        }
        if (!$session->has($key) && !is_null($default)) {
            return $default;
        }
        return $session->get($key);
    }
}

if (! function_exists('request')) {
    function request()
    {
        return Factory::request();
    }
}

if (! function_exists('cookies')) {
    function cookies()
    {
        if (func_num_args() == 0) {
            return Factory::cookies();
        }

        if (func_num_args() == 1) {
            return Factory::cookies()->get(func_get_args()[0]);
        }

        return Factory::cookies()->set(func_get_args());
    }
}

if (! function_exists('config')) {
    function config()
    {
        return Factory::config();
    }
}

if (! function_exists('encrypt')) {
    function encrypt($str)
    {
        return Factory::crypt()->encrypt($str);
    }
}

if (! function_exists('decrypt')) {
    function decrypt($str)
    {
        return Factory::crypt()->decrypt($str);
    }
}

if (! function_exists('dd')) {
    /**
     * Dump the passed variables and end the script.
     *
     * @param  mixed
     * @return void
     */
    function dd()
    {
        array_map(function ($x) {
            (new \App\Utils\Dumper)->dump($x);
        }, func_get_args());

        die(1);
    }
}

if (! function_exists('e')) {
    /**
     * Escape HTML special characters in a string.
     *
     * @param  \Illuminate\Contracts\Support\Htmlable|string  $value
     * @return string
     */
    function e($value)
    {
        return htmlspecialchars($value, ENT_QUOTES, 'UTF-8', false);
    }
}

if (! function_exists('value')) {
    /**
     * Return the default value of the given value.
     *
     * @param  mixed  $value
     * @return mixed
     */
    function value($value)
    {
        return $value instanceof Closure ? $value() : $value;
    }
}

if (! function_exists('env')) {
    /**
     * Gets the value of an environment variable. Supports boolean, empty and null.
     *
     * @param  string  $key
     * @param  mixed   $default
     * @return mixed
     */
    function env($key, $default = null)
    {
        $value = getenv($key);

        if ($value === false) {
            return value($default);
        }

        switch (strtolower($value)) {
            case 'true':
            case '(true)':
                return true;
            case 'false':
            case '(false)':
                return false;
            case 'empty':
            case '(empty)':
                return '';
            case 'null':
            case '(null)':
                return null;
        }

        if (strlen($value) > 1 && strStartsWith($value, '"') && strEndsWith($value, '"')) {
            return substr($value, 1, -1);
        }

        return $value;
    }
}


if (! function_exists('strStartsWith')) {
    /**
     * Determine if a given string starts with a given substring.
     *
     * @param  string  $haystack
     * @param  string|array  $needles
     * @return bool
     */
    function strStartsWith($haystack, $needles)
    {
        foreach ((array) $needles as $needle) {
            if ($needle != '' && substr($haystack, 0, strlen($needle)) === (string) $needle) {
                return true;
            }
        }

        return false;
    }
}



if (! function_exists('strEndsWith')) {
    /**
     * Determine if a given string ends with a given substring.
     *
     * @param  string  $haystack
     * @param  string|array  $needles
     * @return bool
     */
    function strEndsWith($haystack, $needles)
    {
        foreach ((array) $needles as $needle) {
            if (substr($haystack, -strlen($needle)) === (string) $needle) {
                return true;
            }
        }

        return false;
    }
}

if (! function_exists('str_random')) {
    /**
     * Generate a more truly "random" alpha-numeric string.
     *
     * @param  int  $length
     * @return string
     */
    function str_random($length = 16)
    {
        $string = '';

        while (($len = strlen($string)) < $length) {
            $size = $length - $len;

            $bytes = random_bytes($size);

            $string .= substr(str_replace(['/', '+', '='], '', base64_encode($bytes)), 0, $size);
        }

        return $string;
    }
}

