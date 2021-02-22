<?php

namespace App\Command;

use App\Services\OntarioBeer\Http\Client;
use App\Services\OntarioBeer\Import\Importer;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ImportCommand extends Command
{

    protected $ontarioAPIClient;
    protected $ontarioImporter;

    protected static $defaultName = 'app:import';

    public function __construct(Client $ontarioClient, Importer $ontarioImporter)
    {
        $this->ontarioAPIClient = $ontarioClient;
        $this->ontarioImporter = $ontarioImporter;

        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription('Import data from OntarioBeer API service')
            ->setHelp('This command allows you to import beers and breweries from external API...');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Fetching data...');

        try {
            $beers = $this->ontarioAPIClient->getBeers();
            $nBeers = count($beers);

            $output->writeln('Found beers: ' . $nBeers);
            $output->writeln('Importing beers...');

            $progressBar = new ProgressBar($output, $nBeers);
            $progressBar->setFormat('%current%/%max% [%bar%] %percent:3s%% %elapsed:6s%/%estimated:-6s% %memory:6s%');

            foreach ($beers as $beer) {
                $this->ontarioImporter->importBeer($beer);
                $progressBar->advance();
            }

            $progressBar->finish();

            $output->writeln(PHP_EOL . 'Done!');

            return Command::SUCCESS;
        } catch (\Exception $e) {
            $output->writeln($output->writeln(PHP_EOL . 'Import failed!'));

            throw $e;
        }
    }
}