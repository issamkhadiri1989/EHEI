<?php
//src/Command/ExampleCommand.php
declare(strict_types=1);

namespace App\Command;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\ConsoleOutputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\NullOutput;

class ExampleCommand extends Command
{
    // To run : php bin/console example:hello
    protected static $defaultName = "example:hello";
    /**
     * @var EntityManagerInterface
     */
    private $manager;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
        parent::__construct();
    }

    /**
     * Configure the command.
     */
    protected function configure()
    {
        $this->addOption(
            'abc',
            null,
            InputOption::VALUE_OPTIONAL,
            'Files to  delete',
            false
        );

    }

    /**
     * This function is called when the command is executed.
     * It must return an integer. 0 when OK and and integer != 0 when error.
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $command = $this
            ->getApplication()
            ->find('<command>');

        $input = new ArrayInput([
            '<arg>' => '<value>',
            '--<option>' => '<value>'
        ]);

        $code = $command->run($input, new NullOutput());

        return 0;
    }
}