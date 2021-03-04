<?php

namespace TenantCloud\BetterReflection\Relocated;

use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputInterface;
use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\OutputInterface;
use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Style\SymfonyStyle;
//Ensure questions do not output anything when input is non-interactive
return function (\TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputInterface $input, \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\OutputInterface $output) {
    $output = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Style\SymfonyStyle($input, $output);
    $output->title('Title');
    $output->askHidden('Hidden question');
    $output->choice('Choice question with default', ['choice1', 'choice2'], 'choice1');
    $output->confirm('Confirmation with yes default', \true);
    $output->text('Duis aute irure dolor in reprehenderit in voluptate velit esse');
};
