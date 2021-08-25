<?php

namespace Thundar\RateLimit\Plugin;

use Thundar\RateLimit\Api\RateLimitInterface;
use Magento\Customer\Api\AccountManagementInterface;

class AccountManagementPlugin
{
    protected RateLimitInterface $rateLimit;

    public function __construct(
        RateLimitInterface $rateLimit
    ) {
        $this->rateLimit = $rateLimit;
    }

    /**
     * @param AccountManagementInterface $subject
     * @param $customerEmail
     * @param null $websiteId
     * @return null
     */
    public function beforeIsEmailAvailable(
        AccountManagementInterface $subject,
        $customerEmail,
        $websiteId = null
    )
    {
        $this->rateLimit->consume()->ensureAccepted();
        return null;
    }

}
