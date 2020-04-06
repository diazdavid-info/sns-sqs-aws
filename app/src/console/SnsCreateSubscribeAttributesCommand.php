<?php

namespace SnsSqsAws\app\console;

use Aws\Exception\AwsException;
use Aws\Sns\SnsClient;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SnsCreateSubscribeAttributesCommand extends Command
{
    protected static $defaultName = 'sns:create-subscribe-attributes';

    protected function configure(): void
    {
        $this
            ->setDescription('Create subscribe attributes')
            ->setHelp('This command allows you to create a subscribe attributes.')
            ->addArgument('Subscription', InputArgument::REQUIRED, 'Subscription ARN')
            ->addArgument('RoutingKey', InputArgument::REQUIRED, 'Subscription Routing Key');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $subscription = $input->getArgument('Subscription');
        $routingKey = $input->getArgument('RoutingKey');
        $filter = json_encode(['event' => [$routingKey]], JSON_THROW_ON_ERROR, 512);

        $snsClient = new SnsClient([
            'profile' => 'default',
            'region' => 'eu-west-3',
            'version' => 'latest'
        ]);

        try {
            $result = $snsClient->setSubscriptionAttributes([
                'SubscriptionArn' => $subscription,
                'AttributeName' => 'FilterPolicy',
                'AttributeValue' => $filter,
            ]);
            var_dump($result);
            return 0;
        } catch (AwsException $e) {
            error_log($e->getMessage());
            return 1;
        }
    }
}
