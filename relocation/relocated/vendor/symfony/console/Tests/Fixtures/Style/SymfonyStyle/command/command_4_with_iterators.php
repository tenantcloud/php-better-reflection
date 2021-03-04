<?php

namespace TenantCloud\BetterReflection\Relocated;

use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputInterface;
use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\OutputInterface;
use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Style\SymfonyStyle;
//Ensure has single blank line after any text and a title
return function (\TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputInterface $input, \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\OutputInterface $output) {
    $output = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Style\SymfonyStyle($input, $output);
    $output->write('Lorem ipsum dolor sit amet');
    $output->title('First title');
    $output->writeln('Lorem ipsum dolor sit amet');
    $output->title('Second title');
    $output->write('Lorem ipsum dolor sit amet');
    $output->write('');
    $output->title('Third title');
    //Ensure edge case by appending empty strings to history:
    $output->write('Lorem ipsum dolor sit amet');
    $output->write(new \ArrayIterator(['', '', '']));
    $output->title('Fourth title');
    //Ensure have manual control over number of blank lines:
    $output->writeln('Lorem ipsum dolor sit amet');
    $output->writeln(new \ArrayIterator(['', '']));
    //Should append an extra blank line
    $output->title('Fifth title');
    $output->writeln('Lorem ipsum dolor sit amet');
    $output->newLine(2);
    //Should append an extra blank line
    $output->title('Fifth title');
};
