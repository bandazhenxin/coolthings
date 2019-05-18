<?php
/**
 * @author inhere
 * @date: 2015-08-11
 */

namespace Inhere\Validate;

/**
 * Interface ValidationInterface
 * @package Inhere\Validate
 */
interface ValidationInterface
{
    /**
     * @return array
     */
    public function rules();

    /**
     * custom validator's message, to override default message.
     * @return array
     */
    public function messages();

    /**
     * define attribute field translate list
     * @return array
     */
    public function translates();

    /**
     * Data validation
     * @param  array     $onlyChecked 可以设置此次需要验证的字段
     * @param  bool|null $stopOnError 是否出现错误即停止验证
     * @return static
     * @throws \RuntimeException
     */
    public function validate(array $onlyChecked = [], bool $stopOnError = null);

    /**
     * @return bool
     */
    public function fail(): bool;

    /**
     * alias of the fail()
     * @return bool
     */
    public function isFail(): bool;

    /**
     * @return bool
     */
    public function ok(): bool;

    /**
     * @return bool
     */
    public function isPassed(): bool;

    /**
     * @param string $field
     * @return array
     */
    public function getErrors(string $field = ''): array;

    /**
     * Get the first error message
     * @param bool $onlyMsg Only return message string.
     * @return array|string
     */
    public function firstError(bool $onlyMsg = true);

    /**
     * Get the last error message
     * @param bool $onlyMsg
     * @return array|string
     */
    public function lastError(bool $onlyMsg = true);

    /**
     * @return array
     */
    public function getMessages(): array;

    /**
     * @return array|\stdClass
     */
    public function getSafeData();
}