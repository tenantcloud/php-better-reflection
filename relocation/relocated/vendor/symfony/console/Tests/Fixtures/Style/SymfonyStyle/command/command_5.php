<?php

namespace TenantCloud\BetterReflection\Relocated;

use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputInterface;
use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\OutputInterface;
use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Style\SymfonyStyle;
//Ensure has proper line ending before outputting a text block like with SymfonyStyle::listing() or SymfonyStyle::text()
return function (\TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputInterface $input, \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\OutputInterface $output) {
    $output = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Style\SymfonyStyle($input, $output);
    $output->writeln('Lorem ipsum dolor sit amet');
    $output->listing(['Lorem ipsum dolor sit amet', 'consectetur adipiscing elit']);
    //Even using write:
    $output->write('Lorem ipsum dolor sit amet');
    $output->listing(['Lorem ipsum dolor sit amet', 'consectetur adipiscing elit']);
    $output->write('Lorem ipsum dolor sit amet');
    $output->text(['Lorem ipsum dolor sit amet', 'consectetur adipiscing elit']);
    $output->newLine();
    $output->write('Lorem ipsum dolor sit amet');
    $output->comment(['Lorem ipsum dolor sit amet', 'consectetur adipiscing elit']);
};
