<?php
/*
 * This file is part of the <PROJECT> package.
 *
 * (c) Kuborgh GmbH
 *
 * For the full copyright and license information, please view the LICENSE-IMPRESS
 * file that was distributed with this source code.
 */

namespace Kuborgh\Bundle\MeasureBundle\Command;


use eZ\Publish\API\Repository\Values\Content\Query;
use Kuborgh\Bundle\MeasureBundle\Services\LoadContentType\Result;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class PerformanceCommand extends ContainerAwareCommand {

    const ARGUMENT_CONTENT_TYPE = 'ctype';
    const OPTION_ITERATIONS = 'iterations';

    /**
     * Configure command
     */
    protected function configure()
    {
        $this->setName('kb:measure:performance');
        $this->setDescription('Execute performance tests for the given content type and print result.');
        $this->addArgument(self::ARGUMENT_CONTENT_TYPE, null, 'eZ Content Type');
        $this->addOption(self::OPTION_ITERATIONS, 'iter', InputOption::VALUE_OPTIONAL, 'Amount of content objects to load and measure', 100);
    }

    /**
     * Execute the command
     *
     * @param InputInterface  $input  Input
     * @param OutputInterface $output Output
     *
     * @return null|integer null or 0 if everything went fine, or an error code
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $type = $input->getArgument(self::ARGUMENT_CONTENT_TYPE);
        $iterations = $input->getOption(self::OPTION_ITERATIONS);

        if(!$type) {
            $output->writeln('No Content type given. Abort.');
            return;
        }

        $manager = $this->getMeasureManager();

        $measurerNames = array();
        foreach($manager->getMeasurerList() as $measurer) {
            $measurerNames[] = $measurer->getName();
        }

        $output->writeln(sprintf("Running max. %d tests for %s with measurers %s\n...", $iterations, $type, implode(', ', $measurerNames)));
        $resultSet = $manager->run($type, $iterations);

        $output->write("\n<info>Results</info>\n");

        foreach($resultSet as $result) {
            $this->printResult($result, $output);
        }
    }

    /**
     * Print the result
     *
     * @param Result $result
     * @param OutputInterface $output
     */
    protected function printResult(Result $result, OutputInterface $output)
    {
        $output->writeln(sprintf("\nResult for:\t%s", $result->getReference()));
        $output->writeln(sprintf("Iterations:\t%d", $result->getIterations()));
        $output->writeln(sprintf("Min. time:\t%f", $result->getMin()));
        $output->writeln(sprintf("Max. time:\t%f", $result->getMax()));
        $output->writeln(sprintf("Avg. time:\t%f", $result->getAvg()));
    }

    /**
     * @return \Kuborgh\Bundle\MeasureBundle\Services\LoadContentType\Manager
     */
    protected function getMeasureManager()
    {
        return $this->getContainer()->get('kuborgh_measure.service.contenttypeload');
    }
} 