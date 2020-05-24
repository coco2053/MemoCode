<?php

namespace App\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use App\Entity\Country;


/**
 * Responsible for defining the create country command.
 *
 * @package AppBundle\Command
 * @author  Bastien <bastienvacherand@gmail.com>
 */
class CreateCountryCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('app:create-country')
            ->setDescription('Import countries name from a CSV')
            ->addArgument('argument', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $em = $this->getContainer()->get('doctrine')->getManager();
        ini_set("memory_limit", "-1");

        $csv = 'data/country.csv';
        $lines = explode("\n", file_get_contents($csv));
        $countries = [];

        foreach ($lines as $line) {
            $line = explode(',', $line);
            $code = trim($line[1],'"');
            $alpha2 = trim($line[2],'"');
            $alpha3 = trim($line[3],'"');
            $name = trim($line[4],'"');
            $nameUpper =  strtoupper($name);
            $slug = strtolower(trim(preg_replace('/[\s-]+/', '-', preg_replace('/[^A-Za-z0-9-]+/', '-',
                    preg_replace('/[&]/', 'and', preg_replace('/[\']/', '', iconv('UTF-8', 'ASCII//TRANSLIT', $name))))), '-'));
            $country = new Country();
            $country->setName($name);
            $country->setCode($code);
            $country->setAlpha2($alpha2);
            $country->setAlpha3($alpha3);
            $country->setSlug($slug);
            $country->setNameUppercase($nameUpper);
            $countries[] = $name;

            $em->persist($country);
            $output->writeln($name . ' created');

        }
        $em->flush();
        $output->writeln(count($countries) . ' countries imported');
    }
}