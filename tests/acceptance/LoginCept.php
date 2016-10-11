<?php
/**
 * Small test of the login form on index page
 */

$I = new AcceptanceTester($scenario);
$I->wantTo('log in');
$I->amOnPage('/');

$I->click('Login');
$I->see('Email is required');
$I->see('Password is required');

$I->fillField('email', 'wrong email');
$I->click('Login');
$I->see('Email is not a valid email address');
$I->see('Password is required');

$I->fillField('email', 'tester@example.com');
$I->click('Login');
$I->see('Password is required');

$I->fillField('email', 'tester@example.com');
$I->fillField('password', '123');
$I->click('Login');
$I->see('Password must contain greater than 6 characters');

$I->fillField('email', 'tester@example.com');
$I->fillField('password', 'abcdef');
$I->click('Login');
$I->see('Password contains invalid characters');

$I->fillField('email', 'tester@example.com');
$I->fillField('password', '123456');
$I->click('Login');
$I->see('Wrong email or password');
