<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use App\Service\KeywordAnalyzerService;

class ProcessKeywordFilesCommand extends ContainerAwareCommand
{

    private const ACCEPTED_FILE_EXTENSION = '.csv';

    protected static $defaultName = 'app:process-keyword-files';

    protected function configure()
    {
        $this->setDescription('Start generate report from keyword files');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $io->comment('Looking for keyword file to analyze');

        while (true) {
            // Read all files in directory
            $path = $this->getContainer()->getParameter('keyword_files_directory');
            $fileNames = scandir($path);

            foreach ($fileNames as $fileName) {
                // Check if filename is not CSV file
                if (!$this->endsWith($fileName, self::ACCEPTED_FILE_EXTENSION)) continue;

                $io->comment('Start to consuming file "' . $fileName . '"');
                $this->consumeKeywordFile($fileName);
                $io->comment('Analyzed file "' . $fileName . '"');
            }

            sleep(1); // Sleep 1 second before continue to read
        }
    }

    protected function consumeKeywordFile($fileName)
    {
        // Renaming file before consume
        $currentFilePath = $this->getContainer()->getParameter('keyword_files_directory') . '/' . $fileName;
        $newFilePath = $this->getContainer()->getParameter('keyword_files_directory') . '/' . $fileName . '.analyzing';
        rename($currentFilePath, $newFilePath);

        $file = fopen($newFilePath, 'r');
        while (($line = fgetcsv($file)) !== FALSE) {
            $keyword = reset($line); // Get keyword on first column of line

            // Skip empty line / keyword
            if (empty($keyword)) continue;

            $this->getAnalyzerService()->analyzeKeyword($keyword);

            sleep(random_int(1, 10)); // Random time to prevent too many request
        }

        // Rename file after consumed
        $currentFilePath = $this->getContainer()->getParameter('keyword_files_directory') . '/' . $fileName . '.analyzing';
        $newFilePath = $this->getContainer()->getParameter('keyword_files_directory') . '/' . $fileName . '.analyzed';
        rename($currentFilePath, $newFilePath);

        return true;
    }


    /**
     * Get analyzer service
     *
     * @return KeywordAnalyzerService
     */
    public function getAnalyzerService()
    {
        return $this->getContainer()->get(KeywordAnalyzerService::class);
    }

    /**
     * Check string end with sub-string
     *
     *
     * @param string $haystack
     * @param string $needle
     * @return bool
     * 
     * @link https://stackoverflow.com/questions/834303/startswith-and-endswith-functions-in-php
     */
    private function endsWith($haystack, $needle)
    {
        $length = strlen($needle);
        if ($length == 0) {
            return true;
        }

        return (substr($haystack, -$length) === $needle);
    }
}
