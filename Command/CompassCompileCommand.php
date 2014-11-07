<?php
/**
 * User: matteo
 * Date: 16/04/12
 * Time: 23.41
 *
 * Just for fun...
 */

namespace Cypress\CompassElephantBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CompassCompileCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('cypress:compass:compile')
            ->setDescription('Compile all your compass projects')
            ->addArgument('name', InputArgument::OPTIONAL, 'the name of the compass project to compile')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $projects = $this->getContainer()->get('cypress_compass_elephant.project_collection');
        foreach($projects as $project) {
            $output->writeln(sprintf('<info>compiling project</info> %s', $project->getName()));
            $project->compile(true);
        }
    }
}
