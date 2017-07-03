<?php

define('ROOT_DIRECTORY', realpath(__DIR__ . '/..'));
define('SOURCE_DIRECTORY', realpath(ROOT_DIRECTORY . '/src'));

// ini_set('display_errors', 1); error_reporting(E_ALL);

// composer autoloader
require_once ROOT_DIRECTORY . '/vendor/autoload.php';

// router
$klein = new \Klein\Klein();

// general routes
$klein->respond('GET', '*', function () {
    return mmmga\GuestBook\Controller\GuestBook::outputAllEntries();
});
// api routes
$klein->respond('POST', '/api/entries', function ($request, $response) {
    return mmmga\GuestBook\Controller\GuestBook::createNewGuestBookEntry($request->body());
});
$klein->respond('GET', '/api/entries', function () {
    return mmmga\GuestBook\Controller\GuestBook::serveAllEntries();
});
$klein->respond('GET', '/api/entry/[i:id]', function ($request, $response) {
    return mmmga\GuestBook\Controller\GuestBook::outputEntryById($request->id);
});

$klein->dispatch();