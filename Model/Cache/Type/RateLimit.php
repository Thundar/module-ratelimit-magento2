<?php
namespace Thundar\RateLimit\Model\Cache\Type;

use Magento\Framework\App\Cache\Type\FrontendPool;
use Magento\Framework\Cache\Frontend\Decorator\TagScope;

class RateLimit extends TagScope
{
    const TYPE_IDENTIFIER = 'rate_limit';
    const CACHE_TAG = 'RATE_LIMIT_TAG';

    public function __construct(FrontendPool $cacheFrontendPool)
    {
        parent::__construct(
            $cacheFrontendPool->get(self::TYPE_IDENTIFIER),
            self::CACHE_TAG
        );
    }
}
