<?php

namespace SnsSqsAws\app\console;

use Aws\Exception\AwsException;
use Aws\Sns\SnsClient;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SnsDeleteSubscriberCommand extends Command
{
    protected static $defaultName = 'sns:delete-subscriber';

    protected function configure(): void
    {
        $this
            ->setDescription('Delete Subscriber')
            ->setHelp('This command allows you to delete subscriber.')
            ->addArgument('Subscription', InputArgument::REQUIRED, 'Subscription ARN');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $subscription = $input->getArgument('Subscription');

        $snsClient = new SnsClient([
            'profile' => 'default',
            'region' => 'eu-west-3',
            'version' => 'latest'
        ]);

        try {
            $result = $snsClient->unsubscribe([
                'SubscriptionArn' => $subscription,
            ]);
            var_dump($result);
            return 0;
        } catch (AwsException $e) {
            error_log($e->getMessage());
            return 1;
        }
    }
}
