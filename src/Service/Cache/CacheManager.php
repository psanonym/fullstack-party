<?php
declare(strict_types=1);

namespace App\Service\Cache;

use Symfony\Component\Cache\Adapter\AdapterInterface;

class CacheManager
{
    public const TTL_5_MIN = 300;

    /**
     * @var AdapterInterface
     */
    protected $adapter;

    public function __construct(AdapterInterface $cache)
    {
        $this->adapter = $cache;
    }

    public function get(string $cacheKey)
    {
        return $this->adapter->getItem($cacheKey)->get();
    }

    public function isHas(string $cacheKey): bool
    {
        return $this->adapter->getItem($cacheKey)->isHit();
    }

    public function save(string $cacheKey, $data, int $ttl = self::TTL_5_MIN): void
    {
        $cacheItem = $this->adapter
            ->getItem($cacheKey)
            ->set($data)
            ->expiresAfter($ttl);

        $this->adapter->save($cacheItem);
    }
}