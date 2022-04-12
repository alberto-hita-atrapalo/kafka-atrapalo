<?php
namespace App\Command;


use App\Message\LogNotification;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class KafkaCommand extends Command
{
    protected static $defaultName = 'kafka:send';

    /** @var MessageBusInterface  */
    private $bus;

    public function __construct(MessageBusInterface $bus)
    {
        $this->bus = $bus;
        parent::__construct();
    }

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
        $amount = (int)$input->getArgument('amount');

        $output->writeln(sprintf('hola sebas, vales %s', $amount));

        for ($i = 0; $i < $amount; $i++) {
            $this->bus->dispatch(new LogNotification(md5($i)));
        }
    }

}
