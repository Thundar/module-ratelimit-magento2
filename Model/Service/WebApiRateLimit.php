<?php

declare(strict_types=1);

namespace Thundar\RateLimit\Model\Service;

use Magento\Framework\Webapi\Request as HttpRequestInterface;
use Symfony\Component\RateLimiter\RateLimiterFactory;
use Thundar\RateLimit\Api\RateLimitInterface;

class WebApiRateLimit implements RateLimitInterface
{

    protected RateLimiterFactory $factory;
    protected HttpRequestInterface $httpRequest;

    public function __construct(
        RateLimiterFactory $factory,
        HttpRequestInterface $httpRequest
    ){
        $this->factory = $factory;
        $this->httpRequest = $httpRequest;
    }

    public function consume(): \Symfony\Component\RateLimiter\RateLimit
    {
        return $this->getLimiter()->consume();
    }

    public function reset(): void
    {
        $this->getLimiter()->reset();
    }

    protected function getLimiter()
    {
        $ip = $this->httpRequest->getClientIp();
        $service = $this->httpRequest->getPathInfo();
        return $this->factory->create('thundar_request_rate_limit'.$ip.$service);
    }

}
