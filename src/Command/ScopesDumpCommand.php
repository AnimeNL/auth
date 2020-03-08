<?php

namespace App\Command;

use App\Entity\Anplan\Scope;
use App\Normalizer\ScopeNormalizer;
use App\Repository\Anplan\ScopeRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ScopesDumpCommand extends Command
{
    private ScopeRepository $scopeRepository;

    public function __construct(ScopeRepository $scopeRepository)
    {
        $this->scopeRepository = $scopeRepository;
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName('animecon:scopes:dump')
            ->setDescription('Get an array of active scopes to put in the config');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $scopes = $this->scopeRepository->findAll();
        $scopes = array_map(fn (Scope $scope) => '- '.ScopeNormalizer::normalize($scope->getScope()), $scopes);
        $scopes = array_unique($scopes);
        echo implode(PHP_EOL, $scopes);
        echo PHP_EOL;

        return 0;
    }
}
