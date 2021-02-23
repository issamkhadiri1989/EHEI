<?php

declare(strict_types=1);

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Question\Question;

class GreetCommand extends Command
{
    protected static $defaultName = 'greeting';

    //...
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $section = $output->section();
        $table = new Table($section);

        $table->addRow(['Love']);
        $table->render();

        $table->appendRow(['Symfony']);
        return 0;
    }
    //...
}