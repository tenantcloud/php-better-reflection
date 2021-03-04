<?php

declare (strict_types=1);
/**
 * Hoa
 *
 *
 * @license
 *
 * New BSD License
 *
 * Copyright © 2007-2018, Hoa community. All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are met:
 *     * Redistributions of source code must retain the above copyright
 *       notice, this list of conditions and the following disclaimer.
 *     * Redistributions in binary form must reproduce the above copyright
 *       notice, this list of conditions and the following disclaimer in the
 *       documentation and/or other materials provided with the distribution.
 *     * Neither the name of the Hoa nor the names of its contributors may be
 *       used to endorse or promote products derived from this software without
 *       specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS"
 * AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE
 * IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE
 * ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDERS AND CONTRIBUTORS BE
 * LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR
 * CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF
 * SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS
 * INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN
 * CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE)
 * ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 */
namespace Hoa\Math\Test\Unit\Combinatorics\Combination;

use Hoa\Math\Combinatorics\Combination\CartesianProduct as CUT;
use Hoa\Test;
/**
 * Class \Hoa\Math\Test\Unit\Combinatorics\Combination\CartesianProduct.
 *
 * Test suite of the cartesian product.
 *
 * @license    New BSD License
 */
class CartesianProduct extends \Hoa\Test\Unit\Suite
{
    public function case_empty() : void
    {
        $this->given($iterator = new \Hoa\Math\Combinatorics\Combination\CartesianProduct([]))->when($result = \iterator_to_array($iterator))->then->array($result)->isEqualTo([[null]]);
    }
    public function case_X() : void
    {
        $this->given($iterator = new \Hoa\Math\Combinatorics\Combination\CartesianProduct([1, 2, 3]))->when($result = \iterator_to_array($iterator))->then->array($result)->isEqualTo([[1], [2], [3]]);
    }
    public function case_X_Y() : void
    {
        $this->given($iterator = new \Hoa\Math\Combinatorics\Combination\CartesianProduct([1, 2, 3], [4, 5, 6]))->when($result = \iterator_to_array($iterator))->then->array($result)->isEqualTo([[1, 4], [2, 4], [3, 4], [1, 5], [2, 5], [3, 5], [1, 6], [2, 6], [3, 6]]);
    }
    public function case_X_Y_Z() : void
    {
        $this->given($iterator = new \Hoa\Math\Combinatorics\Combination\CartesianProduct([1, 2, 3], [4, 5, 6], [7, 8, 9]))->when($result = \iterator_to_array($iterator))->then->array($result)->isEqualTo([[1, 4, 7], [2, 4, 7], [3, 4, 7], [1, 5, 7], [2, 5, 7], [3, 5, 7], [1, 6, 7], [2, 6, 7], [3, 6, 7], [1, 4, 8], [2, 4, 8], [3, 4, 8], [1, 5, 8], [2, 5, 8], [3, 5, 8], [1, 6, 8], [2, 6, 8], [3, 6, 8], [1, 4, 9], [2, 4, 9], [3, 4, 9], [1, 5, 9], [2, 5, 9], [3, 5, 9], [1, 6, 9], [2, 6, 9], [3, 6, 9]]);
    }
}
