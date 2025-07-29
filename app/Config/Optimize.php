<?php

namespace Config;

/**
 * Optimization Configuration class.
 *
 * This class holds configuration settings related to performance optimization.
 * It does not extend BaseConfig for performance reasons, so property values
 * cannot be replaced with Environment Variables.
 */
class OptimizationConfig
{
    /**
     * Determines whether config caching is enabled.
     *
     * @var bool
     * @see https://codeigniter.com/user_guide/concepts/factories.html#config-caching
     */
    public bool $configCacheEnabled = false;

    /**
     * Determines whether file locator caching is enabled.
     *
     * @var bool
     * @see https://codeigniter.com/user_guide/concepts/autoloader.html#file-locator-caching
     */
    public bool $locatorCacheEnabled = false;
}