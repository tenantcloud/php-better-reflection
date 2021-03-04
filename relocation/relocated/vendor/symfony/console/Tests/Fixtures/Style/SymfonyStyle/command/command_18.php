<?php

namespace TenantCloud\BetterReflection\Relocated;

use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Helper\TableSeparator;
use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputInterface;
use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\OutputInterface;
use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Style\SymfonyStyle;
return function (\TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputInterface $input, \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\OutputInterface $output) {
    $output = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Style\SymfonyStyle($input, $output);
    $output->definitionList(['foo' => 'bar'], new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Helper\TableSeparator(), 'this is a title', new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Helper\TableSeparator(), ['foo2' => 'bar2']);
};
