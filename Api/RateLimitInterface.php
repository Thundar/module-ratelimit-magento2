<?php

namespace Thundar\RateLimit\Api;

/**
 * @api
 */
interface RateLimitInterface
{
    /**
     * @return \Symfony\Component\RateLimiter\RateLimit
     */
    public function consume(): \Symfony\Component\RateLimiter\RateLimit;

    /**
     * @return void
     */
    public function reset(): void;

}
