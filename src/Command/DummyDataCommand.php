<?php

namespace App\Command;

use App\Entity\Wish;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class DummyDataCommand extends ContainerAwareCommand
{
    protected static $defaultName = 'app:dummy-data';

    protected function configure()
    {
        $this
            ->setDescription('Loads dummy data in database');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $doctrine = $this->getContainer()->get("doctrine");
        $connection = $doctrine->getConnection();
        $connection->query("TRUNCATE TABLE wish");
        $io = new SymfonyStyle($input, $output);
        $em = $this->getContainer()->get("doctrine")->getManager();
        $faker = \Faker\Factory::create();
        $wish = new Wish();
        $date = new \DateTime();
        $wish->setLabel($faker->sentence);
        $wish->setDescription($faker->text);
        while ($faker->dateTime > $date){

        }
        $wish->setDateCreated($faker->dateTime);
        $em->persist($wish);
        $em->flush();
        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');
    }
}
