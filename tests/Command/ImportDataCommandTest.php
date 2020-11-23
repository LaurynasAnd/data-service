<?php
namespace App\Tests\Command;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;

class ImportDataCommandTest extends KernelTestCase
{
    public function testExecute()
    {
        $kernel = static::createKernel();
        $application = new Application($kernel);

        $command = $application->find('app:import-data');
        $commandTester = new CommandTester($command);
        $commandTester->execute([
            // pass arguments to the helper
            'directory' => 'C:/xampp/htdocs/mock_backend_data.csv',
        ]);

        // the output of the command in the console
        $output = $commandTester->getDisplay();
        $this->assertStringContainsString('Importing contents from C:/xampp/htdocs/mock_backend_data.csv', $output);
        $this->assertStringContainsString('[OK] Data import completed', $output);

        //check if command stops if file extension is not .csv
        $commandTester->execute([
                    // pass arguments to the helper
                    'directory' => 'C:/xampp/htdocs/mock_backend_data.pdf',
                ]);
        $output = $commandTester->getDisplay();
        $this->assertStringContainsString('File extension is not .csv', $output);
    }
}
