<?php

declare(strict_types=1);

namespace App\ExpressionLanguage;

use Symfony\Component\ExpressionLanguage\ExpressionFunction;
use Symfony\Component\ExpressionLanguage\ExpressionFunctionProviderInterface;

class BasicExpressionProvider implements ExpressionFunctionProviderInterface
{
    /**
     * @return ExpressionFunction[]
     */
    public function getFunctions(): array
    {
        return [
            new ExpressionFunction(
                'lower',
                function ($str) {
                    return sprintf('strtolower(%s)', $str);
                },
                function ($variables, $value) {
                    return strtolower($value);
                }
            ),

            new ExpressionFunction(
                'upper',
                function ($str) {
                    return sprintf('strtoupper(%s)', $str);
                },
                function ($variables, $value) {
                    return strtoupper($value);
                }
            ),

            new ExpressionFunction(
                'trim',
                function ($str) {
                    return sprintf('trim(%s)', $str);
                },
                function ($variables, $value) {
                    return trim($value);
                }
            ),
        ];
    }
}
