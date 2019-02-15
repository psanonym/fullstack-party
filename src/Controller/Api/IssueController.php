<?php
declare(strict_types=1);

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Service\Github as GithubService;


class IssueController extends AbstractController
{

    /**
     * @var GithubService
     */
    protected $githubService;

    public function __construct(GithubService $githubService)
    {
        $this->githubService = $githubService;
    }

    /**
     * @Route("/api/issue/{username}/{repositoryName}/{issueId}", name="issue", methods={"GET"},
     *     requirements={"issueId"="\d+"}
     * )
     */
    public function getIssue(string $username, string $repositoryName, int $issueId): JsonResponse
    {
        return $this->json($this->githubService->getIssue($username, $repositoryName, $issueId));
    }

    /**
     * @Route("/api/issues/{username}/{repositoryName}/{page}", name="issue_list", methods={"GET"},
     *     requirements={"page"="\d+"}
     * )
     */
    public function getIssues(string $username, string $repositoryName, int $page = 1): JsonResponse
    {
        return $this->json($this->githubService->getIssueList($username, $repositoryName, $page));
    }
}