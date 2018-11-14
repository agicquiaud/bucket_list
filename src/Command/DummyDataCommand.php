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
        $io->text("Table wish truncated !");
        $em = $this->getContainer()->get("doctrine")->getManager();
        $faker = \Faker\Factory::create();
        $io->progressStart(1000);
        for($i = 0; $i<1000; $i++) {
            $wish = new Wish();
            $wish->setLabel($faker->sentence);
            $wish->setDescription($faker->optional(0.5)->text(1000));
            $dateCreated = $faker->dateTimeBetween("- 2 years");
            $wish->setDateCreated($dateCreated);
            $dateUpdate = $faker->optional(0.3)->dateTimeBetween($dateCreated);
            $wish->setDateUpdate($dateUpdate);
            $em->persist($wish);
            $io->progressAdvance(1);
        }
        $io->progressFinish();
        $em->flush();
        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');

    }
}
