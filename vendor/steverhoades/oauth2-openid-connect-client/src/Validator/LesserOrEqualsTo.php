<?php
/**
 * @author Steve Rhoades <sedonami@gmail.com>
 * @license http://opensource.org/licenses/MIT MIT
 */
namespace OpenIDConnectClient\Validator;


class LesserOrEqualsTo implements ValidatorInterface
{
    use ValidatorTrait;

    public function isValid($expectedValue, $actualValue)
    {
        if ($actualValue <= $expectedValue) {
            return true;
        }

        $this->message = sprintf("%s is invalid as it is not less than %s", $actualValue, $expectedValue);
        return false;

    }
}
