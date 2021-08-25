<?php

namespace Thundar\RateLimit\Model;

use Thundar\RateLimit\Model\Cache\Type\RateLimit;
use Magento\Framework\App\CacheInterface;
use Magento\Framework\Serialize\Serializer\Json as SerializerInterface;
use Symfony\Component\RateLimiter\LimiterStateInterface;
use Symfony\Component\RateLimiter\Policy\SlidingWindowFactory;
use Symfony\Component\RateLimiter\Storage\StorageInterface;


class CacheStorageBridge implements StorageInterface
{
    protected CacheInterface $cache;

    protected SerializerInterface $serializer;

    protected SlidingWindowFactory $slidingWindowFactory;

    public function __construct(
        CacheInterface $cache,
        SerializerInterface $serializer,
        SlidingWindowFactory $slidingWindowFactory
    )
    {
        $this->cache = $cache;
        $this->serializer = $serializer;
        $this->slidingWindowFactory = $slidingWindowFactory;
    }

    /**
     * @param LimiterStateInterface $limiterState
     */
    public function save(LimiterStateInterface $limiterState): void
    {
        $this->cache->save(
            serialize($limiterState),
            $this->getIdentifier($limiterState),
            [ RateLimit::CACHE_TAG ],
            $limiterState->getExpirationTime()
        );
    }

    /**
     * @param string $limiterStateId
     * @return LimiterStateInterface|null
     */
    public function fetch(string $limiterStateId): ?LimiterStateInterface
    {
        $data = $this->cache->load($this->getIdentifier($limiterStateId));
        if ($data) {
            return unserialize($data);
        }
        return null;
    }

    /**
     * @param string $limiterStateId
     */
    public function delete(string $limiterStateId): void
    {
        $this->cache->remove($this->getIdentifier($limiterStateId));
    }

    /**
     * @param LimiterStateInterface|string $limiter
     * @return string
     */
    protected function getIdentifier($limiter): string
    {
        $suffix = '_';
        if (is_string($limiter)) {
            $suffix .= $limiter;
        } else {
            $suffix .= $limiter->getId();
        }
        return RateLimit::TYPE_IDENTIFIER.$suffix;
    }
}
