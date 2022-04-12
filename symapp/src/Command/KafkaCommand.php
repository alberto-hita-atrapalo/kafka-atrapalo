<?php
namespace App\Command;


use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class KafkaCommand extends Command
{
    protected static $defaultName = 'kafka:send';
    protected function configure()
    {
        $this
            ->setName('kafka:send')
            ->setDefinition([
                new InputArgument('amount', InputArgument::REQUIRED, 'Amount of messages to send')
            ])
            ->setDescription('send messages to kafka')
            ->setHelp(<<<'EOF'
The <info>%command.name%</info> send messages to kafka.
EOF
            )
        ;
    }

    protected function execute(
        InputInterface $input, OutputInterface $output)
    {
        $amount = $input->getArgument('amount');

        $output->writeln(sprintf('hola sebas, vales %s', $amount));
    }

}
