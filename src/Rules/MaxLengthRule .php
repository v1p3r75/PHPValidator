<?php

/**
 * MaxLengthRule - A validation rule implementation for checking if a string field does not exceed a maximum length.
 *
 * @package BlakvGhost\PHPValidator\Rules
 * @author Kabirou ALASSANE
 * @website https://kabirou-alassane.com
 * @github https://github.com/BlakvGhost
 */

namespace BlakvGhost\PHPValidator\Rules;

use BlakvGhost\PHPValidator\LangManager;

class MaxLengthRule implements RuleInterface
{
    /**
     * Name of the field being validated.
     *
     * @var string
     */
    protected $field;

    /**
     * Constructor of the MaxLengthRule class.
     *
     * @param array $parameters Parameters for the rule, specifying the maximum length.
     */
    public function __construct(protected array $parameters)
    {
        // No specific logic needed in the constructor for this rule.
    }

    /**
     * Check if the length of the given string field does not exceed the specified maximum length.
     *
     * @param string $field Name of the field being validated.
     * @param mixed $value Value of the field being validated.
     * @param array $data All validation data.
     * @return bool True if the length is within the specified maximum, false otherwise.
     */
    public function passes(string $field, $value, array $data): bool
    {
        // Set the field property for use in the message method.
        $this->field = $field;

        // Get the maximum length from the parameters, defaulting to 0 if not set.
        $maxLength = $this->parameters[0] ?? 0;

        // Check if the value is a string and its length is within the specified maximum.
        return is_string($value) && mb_strlen($value) <= $maxLength;
    }

    /**
     * Get the validation error message for the max length rule.
     *
     * @return string Validation error message.
     */
    public function message(): string
    {
        // Use LangManager to get a translated validation error message.
        return LangManager::getTranslation('validation.max_length_rule', [
            'attribute' => $this->field,
            'max' => $this->parameters[0] ?? 0,
        ]);
    }
}
