<?php

namespace SnsSqsAws\app\console;

use Aws\Exception\AwsException;
use Aws\Sns\SnsClient;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SnsCreateTopicCommand extends Command
{
    protected static $defaultName = 'sns:create-topic';

    protected function configure(): void
    {
        $this
            ->setDescription('Creates a topic.')
            ->setHelp('This command allows you to create a topic.')
            ->addArgument('Name', InputArgument::REQUIRED, 'Topic Name');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $topicName = $input->getArgument('Name');

        $snsClient = new SnsClient([
            'profile' => 'default',
            'region' => 'eu-west-3',
            'version' => 'latest'
        ]);

        try {
            $result = $snsClient->createTopic([
                'Name' => $topicName,
            ]);
            var_dump($result);
            return 0;
        } catch (AwsException $e) {
            error_log($e->getMessage());
            return 1;
        }

    }
}
