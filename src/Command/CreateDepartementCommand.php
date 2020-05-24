<?php

namespace App\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use App\Entity\Departement;


/**
 * Responsible for defining the create departement command.
 *
 * @package AppBundle\Command
 * @author  Bastien <bastienvacherand@gmail.com>
 */
class CreateDepartementCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('app:create-departement')
            ->setDescription('Import departements name from a CSV')
            ->addArgument('argument', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $em = $this->getContainer()->get('doctrine')->getManager();
        ini_set("memory_limit", "-1");

        $csv = 'data/departement.csv';
        $lines = explode("\n", file_get_contents($csv));
        $dpts = [];


        foreach ($lines as $line) {
            $line = explode(',', $line);
            $code = trim($line[5],'"');
            $slug = trim($line[8],'"');
            $name = trim($line[6],'"');
            $dpt = new Departement();
            $dpt->setName($name);
            $dpt->setCode($code);
            $dpt->setSlug($slug);
            $dpts[] = $name;

            $em->persist($dpt);
            $output->writeln($name . ' created');
        }
        $em->flush();
        $output->writeln(count($dpts) . ' departements imported');
    }
}