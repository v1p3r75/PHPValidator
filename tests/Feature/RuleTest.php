<?php

use BlakvGhost\PHPValidator\LangManager;
use BlakvGhost\PHPValidator\Rules\AcceptedIfRule;
use BlakvGhost\PHPValidator\Rules\AcceptedRule;
use BlakvGhost\PHPValidator\Rules\ActiveURLRule;
use BlakvGhost\PHPValidator\Rules\AlphaNumericRule;
use BlakvGhost\PHPValidator\Rules\AlphaRule;
use BlakvGhost\PHPValidator\Rules\BooleanRule;
use BlakvGhost\PHPValidator\Rules\ConfirmedRule;
use BlakvGhost\PHPValidator\Rules\EmailRule;
use BlakvGhost\PHPValidator\Rules\FileRule;
use BlakvGhost\PHPValidator\Rules\InRule;
use BlakvGhost\PHPValidator\Rules\JsonRule;
use BlakvGhost\PHPValidator\Rules\LowerRule;
use BlakvGhost\PHPValidator\Rules\RequiredWithRule;
use BlakvGhost\PHPValidator\Rules\SizeRule;
use BlakvGhost\PHPValidator\Rules\StringRule;
use BlakvGhost\PHPValidator\Rules\RequiredRule;
use BlakvGhost\PHPValidator\Rules\MaxLengthRule;
use BlakvGhost\PHPValidator\Rules\MinLengthRule;
use BlakvGhost\PHPValidator\Rules\NotInRule;
use BlakvGhost\PHPValidator\Rules\NullableRule;
use BlakvGhost\PHPValidator\Rules\NumericRule;
use BlakvGhost\PHPValidator\Rules\PasswordRule;
use BlakvGhost\PHPValidator\Rules\SameRule;
use BlakvGhost\PHPValidator\Rules\UpperRule;
use BlakvGhost\PHPValidator\Rules\UrlRule;
use BlakvGhost\PHPValidator\Rules\ValidIpRule;

it('validates required rule successfully', function () {
    $validator = new RequiredRule([]);

    expect($validator->passes('field', 'value', ['field' => 'value']))->toBeTrue();
    expect($validator->passes('field', '', []))->toBeFalse();

    expect($validator->message())->toBe(
        LangManager::getTranslation('validation.required_rule', ['attribute' => 'field'])
    );
});

it('validates max length rule successfully', function () {
    $validator = new MaxLengthRule([5]);

    expect($validator->passes('field', 'value', []))->toBeTrue();
    expect($validator->passes('field', 'toolongvalue', []))->toBeFalse();

    expect($validator->message())->toBe(
        LangManager::getTranslation('validation.max_length_rule', ['attribute' => 'field', 'max' => 5])
    );
});

it('validates email rule successfully', function () {
    $validator = new EmailRule([]);

    expect($validator->passes('email', 'test@example.com', []))->toBeTrue();
    expect($validator->passes('email', 'invalid-email', []))->toBeFalse();
    
    expect($validator->message())->toBe(
        LangManager::getTranslation('validation.email_rule', ['attribute' => 'email'])
    );
});

it('validates string rule successfully', function () {
    $validator = new StringRule([]);
    
    expect($validator->passes('field', 'value', []))->toBeTrue();
    expect($validator->passes('field', 5, []))->toBeFalse();
    
    expect($validator->message())->toBe(
        LangManager::getTranslation('validation.string_rule', ['attribute' => 'field'])
    );
});

it('validates min length rule successfully', function () {
    $validator = new MinLengthRule([10]);

    expect($validator->passes('field', 'toolongvalue', []))->toBeTrue();
    expect($validator->passes('field', 'less', []))->toBeFalse();

    expect($validator->message())->toBe(
        LangManager::getTranslation('validation.min_length_rule', ['attribute' => 'field', 'min' => 10])
    );
});

it('validates alpha rule successfully', function () {
    $validator = new AlphaRule([]);

    expect($validator->passes('field', 'Alphabetic', []))->toBeTrue();
    expect($validator->passes('field', 'Alpha123', []))->toBeFalse();

    expect($validator->message())->toBe(
        LangManager::getTranslation('validation.alpha_rule', ['attribute' => 'field'])
    );
});

it('validates accepted if rule successfully', function () {
    $validator = new AcceptedIfRule(['other_field']);

    expect($validator->passes('field', 'some_value', ['other_field' => true]))->toBeTrue();
    expect($validator->passes('field', 'some_value', ['other_field' => false]))->toBeFalse();

    expect($validator->message())->toBe(
        LangManager::getTranslation('validation.accepted_if', ['attribute' => 'field', 'other' => 'other_field'])
    );
});

it('validates accepted rule successfully', function () {
    $validator = new AcceptedRule([]);

    expect($validator->passes('field', '1', []))->toBeTrue();
    expect($validator->passes('field', 'true', []))->toBeTrue();
    expect($validator->passes('field', 'on', []))->toBeTrue();
    expect($validator->passes('field', 'yes', []))->toBeTrue();
    expect($validator->passes('field', 'invalid_value', []))->toBeFalse();

    expect($validator->message())->toBe(
        LangManager::getTranslation('validation.accepted', ['attribute' => 'field'])
    );
});

it('validates same rule successfully', function () {
    $validator = new SameRule(['other_field']);

    expect($validator->passes('field', 'value', ['other_field' => 'value']))->toBeTrue();
    expect($validator->passes('field', 'value', ['other_field' => 'different_value']))->toBeFalse();
    expect($validator->passes('field', 'value', []))->toBeFalse();

    expect($validator->message())->toBe(
        LangManager::getTranslation('validation.same_rule', [
            'attribute' => 'field',
            'otherAttribute' => 'other_field',
        ])
    );
});

it('validates password rule successfully', function () {
    $validator = new PasswordRule([8]);

    expect($validator->passes('password', 'StrongPwd1', []))->toBeTrue();
    expect($validator->passes('password', 'Short1', []))->toBeFalse();
    expect($validator->passes('password', 'lowercase1', []))->toBeFalse();
    expect($validator->passes('password', 'UPPERCASE1', []))->toBeFalse();
    expect($validator->passes('password', 'NoDigit', []))->toBeFalse();

    expect($validator->message())->toBe(
        LangManager::getTranslation('validation.password_rule', [
            'attribute' => 'password',
        ])
    );
});

it('validates numeric rule successfully', function () {
    $validator = new NumericRule([]);

    expect($validator->passes('numericField', 123, []))->toBeTrue();
    expect($validator->passes('numericField', '456', []))->toBeTrue();
    expect($validator->passes('numericField', 'NotNumeric', []))->toBeFalse();
    expect($validator->passes('numericField', null, []))->toBeFalse();

    expect($validator->message())->toBe(
        LangManager::getTranslation('validation.numeric_rule', [
            'attribute' => 'numericField',
        ])
    );
});

it('validates nullable rule successfully', function () {
    $validator = new NullableRule([]);

    expect($validator->passes('nullableField', null, []))->toBeTrue();
    expect($validator->passes('nullableField', 'NotNull', []))->toBeFalse();

    expect($validator->message())->toBe(
        LangManager::getTranslation('validation.nullable_rule', [
            'attribute' => 'nullableField',
        ])
    );
});

it('validates in rule successfully', function () {
    $validValues = ['value1', 'value2', 'value3'];
    $validator = new InRule($validValues);

    expect($validator->passes('field', 'value2', []))->toBeTrue();
    expect($validator->passes('field', 'invalidValue', []))->toBeFalse();

    expect($validator->message())->toBe(
        LangManager::getTranslation('validation.in_rule', [
            'attribute' => 'field',
            'values' => implode(', ', $validValues),
        ])
    );
});

it('validates not in rule successfully', function () {
    $values = ['value1', 'value2', 'value3'];
    $validator = new NotInRule($values);

    expect($validator->passes('field', 'other_value', []))->toBeTrue();
    expect($validator->passes('field', 'value1', []))->toBeFalse();

    expect($validator->message())->toBe(
        LangManager::getTranslation('validation.not_in_rule', [
            'attribute' => 'field',
            'values' => implode(', ', $values),
        ])
    );
});

it('validates confirmed rule successfully', function () {
    $confirmationFieldName = 'confirmation_field';
    $validator = new ConfirmedRule([$confirmationFieldName]);

    // When the confirmation field is present and its value matches the field's value, the validation should pass.
    $data = [
        'field' => 'value',
        $confirmationFieldName => 'value',
    ];
    expect($validator->passes('field', 'value', $data))->toBeTrue();

    // When the confirmation field is present but its value doesn't match the field's value, the validation should fail.
    $data = [
        'field' => 'value1',
        $confirmationFieldName => 'value2',
    ];
    expect($validator->passes('field', 'value1', $data))->toBeFalse();

    // When the confirmation field is not present, the validation should fail.
    $data = [
        'field' => 'value',
    ];
    expect($validator->passes('field', 'value', $data))->toBeFalse();

    expect($validator->message())->toBe(
        LangManager::getTranslation('validation.confirmed_rule', [
            'attribute' => 'field',
            'confirmedAttribute' => $confirmationFieldName,
        ])
    );
});

it('validates active URL rule successfully', function () {
    $validator = new ActiveURLRule([]);

    $data = [];

    // When the URL is valid and has an active DNS record, the validation should pass.
    expect($validator->passes('field', 'https://example.com', $data))->toBeTrue();

    // When the URL is valid but doesn't have an active DNS record, the validation should fail.
    expect($validator->passes('field', 'https://nonexistent.example.com', $data))->toBeFalse();

    // When the URL is not valid, the validation should fail.
    expect($validator->passes('field', 'invalid-url', $data))->toBeFalse();

    expect($validator->message())->toBe(
        LangManager::getTranslation('validation.active_url', [
            'attribute' => 'field',
        ])
    );
});

it('validates lowercase rule successfully', function () {
    $validator = new LowerRule([]);

    expect($validator->passes('field', 'lowercase', []))->toBeTrue();
    expect($validator->passes('field', 'UPPERCASE', []))->toBeFalse();

    expect($validator->message())->toBe(
        LangManager::getTranslation('validation.lowercase_rule', [
            'attribute' => 'field',
        ])
    );
});

it('validates uppercase rule successfully', function () {
    $validator = new UpperRule([]);

    expect($validator->passes('field', 'lowercase', []))->toBeFalse();
    expect($validator->passes('field', 'UPPERCASE', []))->toBeTrue();

    expect($validator->message())->toBe(
        LangManager::getTranslation('validation.uppercase_rule', [
            'attribute' => 'field',
        ])
    );
});

it('validates file rule successfully', function () {
    $validator = new FileRule([]);

    expect($validator->passes('field', __FILE__, []))->toBeTrue();
    expect($validator->passes('field', 'nonexistentfile.txt', []))->toBeFalse();

    expect($validator->message())->toBe(
        LangManager::getTranslation('validation.file_rule', [
            'attribute' => 'field',
        ])
    );
});

it('validates alpha_numeric rule successfully', function () {
    $validator = new AlphaNumericRule([]);

    expect($validator->passes('field', 'alpha2324', []))->toBeTrue();
    expect($validator->passes('field', 's$sdfde$*', []))->toBeFalse();

    expect($validator->message())->toBe(
        LangManager::getTranslation('validation.alpha_numeric', [
            'attribute' => 'field',
        ])
    );
});

it('validates required_with rule successfully', function () {
    $validator = new RequiredWithRule(['other_field']);

    expect($validator->passes('field', 'value', ['other_field' => 'value2']))->toBeTrue();
    expect($validator->passes('field', 'value', []))->toBeFalse();

    expect($validator->message())->toBe(
        LangManager::getTranslation('validation.required_with', [
            'attribute' => 'field',
            'value' => 'other_field',
        ])
    );
});

it('validates boolean rule successfully', function () {
    $validator = new BooleanRule([]);

    expect($validator->passes('field', false, []))->toBeTrue();
    expect($validator->passes('field', 'string', []))->toBeFalse();

    expect($validator->message())->toBe(
        LangManager::getTranslation('validation.boolean', [
            'attribute' => 'field',
        ])
    );
});

it('validates json rule successfully', function () {
    $validator = new JsonRule([]);

    expect($validator->passes('field', "", []))->toBeFalse();
    expect($validator->passes('field', '{"name":"vishal", "email": "abc@gmail.com"}', []))->toBeTrue();
    expect($validator->passes('field', '{name:vishal, email: abc@gmail.com}', []))->toBeFalse();

    expect($validator->message())->toBe(
        LangManager::getTranslation('validation.json', [
            'attribute' => 'field',
        ])
    );
});

it('validates url rule successfully', function () {
    $validator = new UrlRule([]);

    expect($validator->passes('field', "invalid_url", []))->toBeFalse();
    expect($validator->passes('field', 'http://google.com', []))->toBeTrue();

    expect($validator->message())->toBe(
        LangManager::getTranslation('validation.url', [
            'attribute' => 'field',
        ])
    );
});

it('validates ip rule successfully', function () {
    $validator = new ValidIpRule([]);

    expect($validator->passes('field', "3853598", []))->toBeFalse();
    expect($validator->passes('field', '127.0.0.1', []))->toBeTrue();

    expect($validator->message())->toBe(
        LangManager::getTranslation('validation.valid_ip', [
            'attribute' => 'field',
        ])
    );
});

it('validates size rule (string) successfully', function () {
    $validator = new SizeRule([4]);

    expect($validator->passes('field', "azerty", []))->toBeFalse();
    expect($validator->passes('field', 'azer', []))->toBeTrue();

    expect($validator->message())->toBe(
        LangManager::getTranslation('validation.size', [
            'attribute' => 'field',
            'value' => 4,
        ])
    );
});

it('validates size rule (integer) successfully', function () {
    $validator = new SizeRule([3]);

    expect($validator->passes('field', 6, []))->toBeFalse();
    expect($validator->passes('field', 3, []))->toBeTrue();

    expect($validator->message())->toBe(
        LangManager::getTranslation('validation.size', [
            'attribute' => 'field',
            'value' => 3,
        ])
    );
});

it('validates size rule (array) successfully', function () {
    $validator = new SizeRule([2]);

    expect($validator->passes('field', ['key1', 'key2', 'key3'], []))->toBeFalse();
    expect($validator->passes('field', ['key1', 'key2'], []))->toBeTrue();

    expect($validator->message())->toBe(
        LangManager::getTranslation('validation.size', [
            'attribute' => 'field',
            'value' => 2,
        ])
    );
});

it('validates size rule (file) successfully', function () {
    $validator = new SizeRule([512]);

    expect($validator->passes('field', __FILE__, []))->toBeFalse();
    // expect($validator->passes('field', __FILE__, []))->toBeTrue();

    expect($validator->message())->toBe(
        LangManager::getTranslation('validation.size', [
            'attribute' => 'field',
            'value' => 512,
        ])
    );
});