<?php namespace Phoenix\EloquentMeta;

class Helpers
{
    /**
     * Checks if a value is json encoded
     *
     * @return mixed
     */
    public static function maybeDecode($value, $asArray = false)
    {
        if (!is_string($value))
        {
            return $value;
        }

        $decoded = json_decode($value, $asArray);

        return json_last_error() == JSON_ERROR_NONE ? $decoded : $value;
    }

    /**
     * Checks if a value needs to get json encoded
     *
     * @return mixed
     */
    public static function maybeEncode($value)
    {
        if (is_array($value) || is_object($value))
        {
            $value = json_encode($value);
        }

        return $value;
    }
}
