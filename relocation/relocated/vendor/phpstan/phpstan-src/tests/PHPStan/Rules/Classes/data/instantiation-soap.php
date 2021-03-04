<?php

namespace TenantCloud\BetterReflection\Relocated\TestInstantiation;

function () {
    throw new \SoapFault('Server', 123);
    throw new \SoapFault('Server', 'Some error message');
};
