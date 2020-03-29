<?php

namespace SnsSqsAws\app\console;

use Aws\Exception\AwsException;
use Aws\Sns\SnsClient;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SnsDeleteTopicCommand extends Command
{
    protected static $defaultName = 'sns:delete-topic';

    protected function configure(): void
    {
        $this
            ->setDescription('Delete Topic')
            ->setHelp('This command allows you to delete a topic')
            ->addArgument('ARN', InputArgument::REQUIRED, 'Code ARN');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $topic = $input->getArgument('ARN');

        $snsClient = new SnsClient([
            'profile' => 'default',
            'region' => 'eu-west-3',
            'version' => 'latest'
        ]);

        try {
            $result = $snsClient->deleteTopic([
                'TopicArn' => $topic,
            ]);
            var_dump($result);
            return 0;
        } catch (AwsException $e) {
            error_log($e->getMessage());
            return 1;
        }
    }
}
