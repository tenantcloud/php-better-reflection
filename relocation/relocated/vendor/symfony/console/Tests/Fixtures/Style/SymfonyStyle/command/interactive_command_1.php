<?php

namespace TenantCloud\BetterReflection\Relocated;

use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputInterface;
use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\OutputInterface;
use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Style\SymfonyStyle;
//Ensure that questions have the expected outputs
return function (\TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputInterface $input, \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\OutputInterface $output) {
    $output = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Style\SymfonyStyle($input, $output);
    $stream = \fopen('php://memory', 'r+', \false);
    \fwrite($stream, "Foo\nBar\nBaz");
    \rewind($stream);
    $input->setStream($stream);
    $output->ask('What\'s your name?');
    $output->ask('How are you?');
    $output->ask('Where do you come from?');
};
