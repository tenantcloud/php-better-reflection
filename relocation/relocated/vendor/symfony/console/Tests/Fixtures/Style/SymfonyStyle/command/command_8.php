<?php

namespace TenantCloud\BetterReflection\Relocated;

use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Helper\TableCell;
use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputInterface;
use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\OutputInterface;
use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Style\SymfonyStyle;
//Ensure formatting tables when using multiple headers with TableCell
return function (\TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputInterface $input, \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\OutputInterface $output) {
    $headers = [[new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Helper\TableCell('Main table title', ['colspan' => 3])], ['ISBN', 'Title', 'Author']];
    $rows = [['978-0521567817', 'De Monarchia', new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Helper\TableCell("Dante Alighieri\nspans multiple rows", ['rowspan' => 2])], ['978-0804169127', 'Divine Comedy']];
    $output = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Style\SymfonyStyle($input, $output);
    $output->table($headers, $rows);
};
