<?php

use BlakvGhost\PHPValidator\Validator;
use BlakvGhost\PHPValidator\ValidatorException;
use BlakvGhost\PHPValidator\LangManager;

it('throws exception if data is empty', function () {
    expect(fn () => new Validator([], ['name' => 'string']))
        ->toThrow(ValidatorException::class, LangManager::getTranslation('validation.empty_data'));
});

it('throws exception if rules are empty', function () {
    expect(fn () => new Validator(['name' => 'John'], []))
        ->toThrow(ValidatorException::class, LangManager::getTranslation('validation.empty_rules'));
});

it('throws exception if rule not found', function () {
    expect(fn () => new Validator(['name' => 'John'], ['name' => 'nonexistent']))
        ->toThrow(ValidatorException::class, LangManager::getTranslation('validation.rule_not_found', ['ruleName' => 'nonexistent']));
});
