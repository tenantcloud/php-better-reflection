<?php

namespace TenantCloud\BetterReflection\Relocated\DependentVariableCertainty;

use TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic;
use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType;
use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertVariableCertainty;
function (bool $b, bool $c) : void {
    if ($b) {
        $foo = 'bla';
    }
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertVariableCertainty(\TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe(), $foo);
    if ($b) {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertVariableCertainty(\TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes(), $foo);
    } else {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertVariableCertainty(\TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo(), $foo);
    }
    if ($b) {
    }
    if ($b) {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertVariableCertainty(\TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes(), $foo);
    } else {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertVariableCertainty(\TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo(), $foo);
    }
    if ($b) {
        $d = \true;
    }
    if ($b) {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertVariableCertainty(\TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes(), $foo);
    } else {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertVariableCertainty(\TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo(), $foo);
    }
    if ($c) {
        $bar = 'ble';
    }
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertVariableCertainty(\TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe(), $foo);
    if ($b) {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertVariableCertainty(\TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes(), $foo);
    } else {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertVariableCertainty(\TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo(), $foo);
    }
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertVariableCertainty(\TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe(), $foo);
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertVariableCertainty(\TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe(), $bar);
    if ($c) {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertVariableCertainty(\TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe(), $foo);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertVariableCertainty(\TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes(), $bar);
    } else {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertVariableCertainty(\TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe(), $foo);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertVariableCertainty(\TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo(), $bar);
    }
};
function (bool $b) : void {
    if ($b) {
        $foo = 'bla';
    }
    $b = \true;
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertVariableCertainty(\TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe(), $foo);
    if ($b) {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertVariableCertainty(\TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe(), $foo);
    } else {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertVariableCertainty(\TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe(), $foo);
    }
};
function (bool $b) : void {
    if ($b) {
        $foo = 'bla';
    }
    $foo = 'ble';
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertVariableCertainty(\TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes(), $foo);
    if ($b) {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertVariableCertainty(\TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes(), $foo);
    } else {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertVariableCertainty(\TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes(), $foo);
    }
};
function (bool $a, bool $b) {
    if ($a) {
        $lorem = 'test';
    }
    if ($a) {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertVariableCertainty(\TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes(), $lorem);
    }
    while ($b) {
        $foo = 'foo';
        if (\rand(0, 1)) {
            break;
        }
    }
    if ($a) {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertVariableCertainty(\TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes(), $lorem);
    }
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertVariableCertainty(\TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe(), $foo);
    if ($b) {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertVariableCertainty(\TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes(), $foo);
    }
    if ($a) {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertVariableCertainty(\TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes(), $lorem);
    }
};
function (bool $a, bool $b) {
    if ($a) {
        $lorem = 'test';
    }
    if ($a) {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertVariableCertainty(\TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes(), $lorem);
    }
    $i = 0;
    while ($b) {
        $foo = 'foo';
        $i++;
        if (\rand(0, 1)) {
            break;
        }
    }
    if ($a) {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertVariableCertainty(\TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes(), $lorem);
    }
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertVariableCertainty(\TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe(), $foo);
    if ($b) {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertVariableCertainty(\TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes(), $foo);
    }
    if ($a) {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertVariableCertainty(\TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes(), $lorem);
    }
};
function (bool $a, bool $b) : void {
    if ($a) {
        $lorem = 'test';
    }
    if ($a) {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertVariableCertainty(\TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes(), $lorem);
    }
    unset($b);
    if ($a) {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertVariableCertainty(\TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes(), $lorem);
    }
};
function (bool $a, bool $b) : void {
    if ($a) {
        $lorem = 'test';
    }
    if ($a) {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertVariableCertainty(\TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes(), $lorem);
    }
    unset($lorem);
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertVariableCertainty(\TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo(), $lorem);
    if ($a) {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertVariableCertainty(\TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo(), $lorem);
    }
};
function (bool $is_valid_a) : void {
    if ($is_valid_a) {
        $a = new \stdClass();
    } else {
        $a = null;
    }
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('stdClass|null', $a);
    if ($is_valid_a) {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('stdClass', $a);
    } else {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('null', $a);
    }
};
function (?\stdClass $a) : void {
    if ($a) {
        $is_valid_a = \true;
    } else {
        $is_valid_a = \false;
    }
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('stdClass|null', $a);
    if ($is_valid_a) {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('stdClass', $a);
    } else {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('null', $a);
    }
};
function (bool $a, bool $b) : void {
    if ($a) {
        $lorem = 'test';
    }
    if ($a) {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertVariableCertainty(\TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes(), $lorem);
    }
    unset($a);
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertVariableCertainty(\TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe(), $lorem);
    if ($a) {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertVariableCertainty(\TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe(), $lorem);
    }
};
function () : void {
    $from = null;
    $to = null;
    if (\rand(0, 1)) {
        $from = new \stdClass();
        $to = new \stdClass();
    }
    if ($from !== null) {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('stdClass', $to);
    }
};
/*function (): void {
	$from = null;
	$to = null;
	if (rand(0, 1)) {
		$from = new \stdClass();
		$to = new \stdClass();
	}

	if (rand(0, 1)) {
		$from = new \stdClass();
		$to = new \stdClass();
	}

	if ($from !== null) {
		assertType('stdClass', $to);
	}
};

function (bool $b): void {
	$from = null;
	$to = null;
	if ($b) {
		$from = new \stdClass();
		$to = new \stdClass();
	}

	if ($from !== null) {
		assertType('true', $b);
		assertType('stdClass', $from);
		assertType('stdClass', $to);
	}
};

function (bool $b): void {
	$from = null;
	$to = null;
	if ($b) {
		$from = new \stdClass();
		$to = new \stdClass();
	}

	if ($b) {
		assertType('true', $b);
		assertType('stdClass', $from);
		assertType('stdClass', $to);
	}
};

function (bool $b, bool $c): void {
	if ($b) {
		if ($c) {
			$foo = 'bla';
		}
	}

	assertVariableCertainty(TrinaryLogic::createMaybe(), $foo);

	if ($b) {
		assertVariableCertainty(TrinaryLogic::createMaybe(), $foo);
		if ($c) {
			assertVariableCertainty(TrinaryLogic::createYes(), $foo);
		} else {
			assertVariableCertainty(TrinaryLogic::createNo(), $foo);
		}
	} else {
		assertVariableCertainty(TrinaryLogic::createNo(), $foo);
		if (!$c) {
			assertVariableCertainty(TrinaryLogic::createNo(), $foo);
		} else {
			assertVariableCertainty(TrinaryLogic::createNo(), $foo);
		}
	}

	if (!$b && !$c) {
		assertVariableCertainty(TrinaryLogic::createNo(), $foo);
	}
};

function (bool $b, bool $c): void {
	if ($b && $c) {
		$foo = 'bla';
	}

	assertVariableCertainty(TrinaryLogic::createMaybe(), $foo);

	if ($b) {
		assertVariableCertainty(TrinaryLogic::createMaybe(), $foo);
		if ($c) {
			assertVariableCertainty(TrinaryLogic::createYes(), $foo);
		} else {
			assertVariableCertainty(TrinaryLogic::createNo(), $foo);
		}
	} else {
		assertVariableCertainty(TrinaryLogic::createNo(), $foo);
		if (!$c) {
			assertVariableCertainty(TrinaryLogic::createNo(), $foo);
		} else {
			assertVariableCertainty(TrinaryLogic::createNo(), $foo);
		}
	}

	if (!$b && !$c) {
		assertVariableCertainty(TrinaryLogic::createNo(), $foo);
	}
};

function (bool $b, bool $c, bool $d): void {
	if ($b) {
		if ($c) {
			$foo = 'bla';
		}
	}

	if ($d) {
		$foo = 'ble';
	}

	assertVariableCertainty(TrinaryLogic::createMaybe(), $foo);
	assertType('\'bla\'|\'ble\'', $foo);

	if ($b) {
		assertVariableCertainty(TrinaryLogic::createMaybe(), $foo);
		assertType('\'bla\'|\'ble\'', $foo);
		if ($c) {
			assertVariableCertainty(TrinaryLogic::createYes(), $foo);
			assertType('\'bla\'|\'ble\'', $foo);
			if (!$d) {
				assertVariableCertainty(TrinaryLogic::createYes(), $foo);
				assertType('\'bla\'', $foo);
			} else {
				assertVariableCertainty(TrinaryLogic::createYes(), $foo);
				assertType('\'ble\'', $foo);
			}
		}
	} else {
		assertVariableCertainty(TrinaryLogic::createMaybe(), $foo);
		assertType('\'ble\'', $foo);
		if (!$c) {
			assertVariableCertainty(TrinaryLogic::createMaybe(), $foo);
			assertType('\'ble\'', $foo);
			if (!$d) {
				assertVariableCertainty(TrinaryLogic::createNo(), $foo);
				assertType('*ERROR*', $foo);
			}
		}
	}

	if (!$b && !$c) {
		assertVariableCertainty(TrinaryLogic::createMaybe(), $foo);
		assertType('\'ble\'', $foo);
		if (!$d) {
			assertVariableCertainty(TrinaryLogic::createNo(), $foo);
			assertType('*ERROR*', $foo);
		} else {
			assertVariableCertainty(TrinaryLogic::createYes(), $foo);
			assertType('\'ble\'', $foo);
		}
	}

	if ($d) {
		assertVariableCertainty(TrinaryLogic::createYes(), $foo);
		assertType('\'bla\'|\'ble\'', $foo);
	} else {
		assertVariableCertainty(TrinaryLogic::createMaybe(), $foo);
		assertType('\'bla\'', $foo);
		if (!$b && !$c) {
			assertVariableCertainty(TrinaryLogic::createNo(), $foo);
			assertType('*ERROR*', $foo);
		}
	}
};

function (bool $b, bool $c, bool $d): void {
	if ($d) {
		$foo = 'ble';
	}

	if ($b) {
		if ($c) {
			$foo = 'bla';
		}
	}

	assertVariableCertainty(TrinaryLogic::createMaybe(), $foo);
	assertType('\'bla\'|\'ble\'', $foo);

	if ($b) {
		assertVariableCertainty(TrinaryLogic::createMaybe(), $foo);
		assertType('\'bla\'|\'ble\'', $foo);
		if ($c) {
			assertVariableCertainty(TrinaryLogic::createYes(), $foo);
			assertType('\'bla\'', $foo);
			if (!$d) {
				assertVariableCertainty(TrinaryLogic::createYes(), $foo);
				assertType('\'bla\'', $foo);
			} else {
				assertVariableCertainty(TrinaryLogic::createYes(), $foo);
				assertType('\'bla\'', $foo);
			}
		} else {
			assertVariableCertainty(TrinaryLogic::createMaybe(), $foo);
			assertType('\'ble\'', $foo);
			if ($d) {
				assertVariableCertainty(TrinaryLogic::createYes(), $foo);
				assertType('\'ble\'', $foo);
			} else {
				assertVariableCertainty(TrinaryLogic::createNo(), $foo);
			}
		}
	} else {
		assertVariableCertainty(TrinaryLogic::createMaybe(), $foo);
		assertType('\'ble\'', $foo);
		if ($d) {
			assertVariableCertainty(TrinaryLogic::createYes(), $foo);
			assertType('\'ble\'', $foo);
		} else {
			assertVariableCertainty(TrinaryLogic::createNo(), $foo);
		}
	}
};*/
