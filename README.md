# Magento WebAPI Rate Limiter Beta

This module implements `symfony/rate-limiter` to be used with Magento APIs.
It uses Magento's cache storage to store the cached objects.

### Installation
Enable rate_limit cache type:
`bin/magento cache:enable rate_limit`

Due to a bug in magento di, you should apply the following patch to
`symfony/rate-limit`:
```
--- a/RateLimiterFactory.php	2021-08-20 16:57:27.000000000 +0200
+++ b/RateLimiterFactory.php	2021-08-20 16:57:18.000000000 +0200
@@ -37,7 +37,7 @@
{
$this->storage = $storage;
$this->lockFactory = $lockFactory;
-
+        $config['limit'] = (int)$config['limit'];
         $options = new OptionsResolver();
         self::configureOptions($options);
```
### Usage
Add `\Thundar\RateLimit\Api\RateLimitInterface::consume()` where needed.
