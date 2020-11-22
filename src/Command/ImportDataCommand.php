<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use League\Csv\Reader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class ImportDataCommand extends Command
{

    public function __construct(EntityManagerInterface $em){
        $this->em = $em;
        parent::__construct();
    }
    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'app:import-data';

    protected function configure()
    {
        $this
        ->setDescription('Imports .csv data and saves to database. File directory is mandatory')
        ->addArgument(
            'directory',
            InputArgument::REQUIRED,
            'Directory to source file'
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $start = getdate();
        $io = new SymfonyStyle($input, $output);
        $io->title('Importing contents from ' . $input->getArgument('directory'));
        //Reader will import data from destination .csv file
        $io->section('Downloading file contents');
        $csv = Reader::createFromPath(
            $input->getArgument('directory'), 'r'
            )
            ->setHeaderOffset(0);
            
        // getRecords method returns Iterator class object
        $data = $csv->getRecords();
            
        $io->section('Migrating data to database');
        $io->progressStart(iterator_count($data));

        $this->em->getConnection()->getConfiguration()->setSQLLogger(null);
        foreach($data as $row){
            $sql = "INSERT INTO server (date, client, sign_smartid, sign_mobile, sign_sc, authorize_smartid, authorize_mobile, authorize_sc, ocsp, crl)
                VALUES(:date, :client, :sign_smartid, :sign_mobile, :sign_sc, :authorize_smartid, :authorize_mobile, :authorize_sc, :ocsp, :crl)";
        
            $stmt = $this->em->getConnection()->prepare($sql);
            $r = $stmt->execute(array(
                'date'      => $row['date'],
                'client'       => $row['client'],
                'sign_smartid'    => intval($row['sign_smartid']),
                'sign_mobile'  => intval($row['sign_mobile']),
                'sign_sc'        => intval($row['sign_sc']),
                'authorize_smartid'     => intval($row['authorize_smartid']),
                'authorize_mobile'     => intval($row['authorize_mobile']),
                'authorize_sc'     => intval($row['authorize_sc']),
                'ocsp'     => intval($row['ocsp']),
                'crl'     => intval($row['crl']),
            ));
            
            $io->progressAdvance();
        }
        $this->em->flush();
        $this->em->clear();

        $io->progressFinish();
        $io->success('Data import completed');
        //following lines are used to calculate time needed to migrate data
        $end = getdate(); 
        $time = ($end['minutes']*60 + $end['seconds']) - ($start['minutes']*60 + $start['seconds']);
        $time = floor($time/60). ' minutes ' . $time%60 . ' seconds';
        $output->writeln('Finished in ' . $time);
        
        return Command::SUCCESS;
    }


}
