<?php

namespace SnsSqsAws\app\console;

use Aws\Exception\AwsException;
use Aws\Sns\SnsClient;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SnsPublishMessageCommand extends Command
{
    protected static $defaultName = 'sns:publish-message';

    protected function configure(): void
    {
        $this
            ->setDescription('Publish Message')
            ->setHelp('This command allows you to publish a message')
            ->addArgument('ARN', InputArgument::REQUIRED, 'Code ARN')
            ->addArgument('RoutingKey', InputArgument::REQUIRED, 'Subscribe Routing Key')
            ->addArgument('Message', InputArgument::REQUIRED, 'Message');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $topic = $input->getArgument('ARN');
        $message = $input->getArgument('Message');
        $routingKey = $input->getArgument('RoutingKey');

        $snsClient = new SnsClient([
            'profile' => 'default',
            'region' => 'eu-west-3',
            'version' => 'latest'
        ]);

        try {
            $result = $snsClient->publish([
                'Message' => $message,
                'TopicArn' => $topic,
                'MessageAttributes' => [
                    'event' => [
                        'DataType' => 'String',
                        'StringValue' => $routingKey,
                    ],
                ],
            ]);
            var_dump($result);
            return 0;
        } catch (AwsException $e) {
            error_log($e->getMessage());
            return 1;
        }
    }
}
