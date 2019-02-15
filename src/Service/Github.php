<?php
declare(strict_types=1);

namespace App\Service;

use App\Service\Cache\CacheManager;
use Github\Client;

class Github
{
    public const PER_PAGE = 10;

    /**
     * @var CacheManager
     */
    protected $cache;

    /**
     * @var Client
     */
    protected $githubClient;

    public function __construct(CacheManager $cache, Client $githubClient)
    {
        $this->cache = $cache;
        $this->githubClient = $githubClient;
    }

    /**
     * @param string $username
     * @param string $repositoryName
     * @param $issueNumber
     * @return array
     */
    public function getIssue(string $username, string $repositoryName, $issueNumber): array
    {
        $cacheKey = __FUNCTION__ . "{$username}_{$repositoryName}_{$issueNumber}";

        if (!$this->cache->isHas($cacheKey)) {
            $issue = $this->githubClient
                ->api('issue')
                ->show($username, $repositoryName, $issueNumber);

            $this->cache->save($cacheKey, $issue);
        }

        return $this->cache->get($cacheKey);
    }

    /**
     * @param string $username
     * @param string $repositoryName
     * @param int $page
     * @return array
     */
    public function getIssueList(string $username, string $repositoryName, int $page): array
    {
        $cacheKey = __FUNCTION__ . "{$username}_{$repositoryName}_{$page}";

        if (!$this->cache->isHas($cacheKey)) {
            $issueList = $this->githubClient->api('issue')->all($username, $repositoryName, [
                'page' => $page,
                'per_page' => self::PER_PAGE
            ]);
            $this->cache->save($cacheKey, $issueList);
        }

        return $this->cache->get($cacheKey);
    }
}