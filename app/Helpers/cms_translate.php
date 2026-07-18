<?php

if (! function_exists('cms_translate')) {
    /**
     * Returns the key as-is (translation layer removed).
     * Previously wrapped trans('cms.'.$key).
     */
    function cms_translate($key)
    {
        return $key;
    }
}
