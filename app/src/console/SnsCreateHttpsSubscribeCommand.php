<?php

namespace SnsSqsAws\app\console;

use Aws\Exception\AwsException;
use Aws\Sns\SnsClient;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SnsCreateHttpsSubscribeCommand extends Command
{
    protected static $defaultName = 'sns:create-https-subscribe';

    protected function configure(): void
    {
        $this
            ->setDescription('Create https subscribe')
            ->setHelp('This command allows you to create a https subscribe.')
            ->addArgument('ARN', InputArgument::REQUIRED, 'Code ARN')
            ->addArgument('URL', InputArgument::REQUIRED, 'URL');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $protocol = 'https';
        $endpoint = $input->getArgument('URL');
        $topic = $input->getArgument('ARN');

        $snsClient = new SnsClient([
            'profile' => 'default',
            'region' => 'eu-west-3',
            'version' => 'latest'
        ]);

        try {
            $result = $snsClient->subscribe([
                'Protocol' => $protocol,
                'Endpoint' => $endpoint,
                'ReturnSubscriptionArn' => true,
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
