<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use phpDocumentor\Reflection\Types\Boolean;
use phpDocumentor\Reflection\Types\Integer;

class Inn implements Rule
{
    protected $messageText = 'Данный ИНН не прошел валидацию.';

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        /* check for only num*/
        if(!$this->checkIsNumeric($value))
            return false;

        $length = $this->checkLength($value);
        if ($length === false)
            return false;
        return ($length === 10) ? $this->checkShortInnValid($value) : $this->checkLongInnValid($value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return $this->messageText;
    }

    /**
     * check that length of value is 10 or 12
     * @param $value
     * @return bool|int
     */
    protected function checkLength($value)
    {
        $length = strlen($value);
        if (($length === 10) || ($length === 12)) {
            return $length;
        }
        $this->messageText = 'Длина инн должна быть 10 или 12 символов.';
        return false;
    }

    /**
     * @param $value
     * @return bool
     */
    protected function checkIsNumeric($value) : bool
    {
        if(ctype_digit($value)){
            return true;
        }
        $this->messageText = 'Некорректный формат ИНН.';
        return false;
    }

    /**
     * check inn with rules for 10-length
     * @param $value
     * @return bool
     */
    protected function checkShortInnValid($value): bool
    {
        $coefficients = [2, 4, 10, 3, 5, 9, 4, 6, 8, 0];
        $controlNumber = $this->getControlNumber($coefficients, 10, $value);
        return $controlNumber === intval($value[9]);
    }

    /**
     * check inn with rules for 12-length
     * @param $value
     * @return bool
     */
    protected function checkLongInnValid($value): bool
    {
        /* get control number 11 position */
        $eleventhCoefficients = [7, 2, 4, 10, 3, 5, 9, 4, 6, 8, 0];
        $eleventhControlNum = $this->getControlNumber($eleventhCoefficients, 11, $value);

        /*get control summ 12*/
        $twelfthCoefficients = [3, 7, 2, 4, 10, 3, 5, 9, 4, 6, 8, 0];
        $twelfthControlNum = $this->getControlNumber($twelfthCoefficients, 12, $value);

        $eleventhCorrect = ($eleventhControlNum === intval($value[10]));
        $twelfthCorrect = ($twelfthControlNum === intval($value[11]));

        return (($eleventhCorrect === true) && ($twelfthCorrect === true));
    }

    /**
     * @param array $coefficients
     * @param int $length
     * @param string $value
     * @return int
     */
    protected function getControlNumber(array $coefficients, int $length, string $value): int
    {
        $controlSum = 0;
        for ($i = 0; $i < $length; $i++) {
            $controlSum += intval($value[$i]) * $coefficients[$i];
        }

        /*get control num */
        $controlNum = $controlSum % 11;

        if ($controlNum > 9) {
            $controlNum = $controlNum % 10;
        }

        return $controlNum;
    }
}
