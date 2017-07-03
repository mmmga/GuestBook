<?php

namespace mmmga\GuestBook\Controller;

use Smarty;
use mmmga\GuestBook\Model\GuestBook as GuestBookModel;
use mmmga\GuestBook\Model\GuestBookEntry as GuestBookEntryModel;

class GuestBook {

    public static function createNewGuestBookEntry($inputData) {
        $guestBookData = json_decode($inputData, $assArray=true);
        $guestBookEntryModel = GuestBookEntryModel::generateNewEntry($guestBookData);
        return json_encode($guestBookEntryModel->toArray());
    }

    public static function serveAllEntries() {
        $guestBookModel = new GuestBookModel();
        $guestBookEntries = $guestBookModel->getAllEntries($doFetch = true);
        return json_encode(
            array_map(
                function($guestBookEntry) {
                    return $guestBookEntry->toArray();
                }, $guestBookEntries
            )
        );
    }

    public static function serveEntryById($id) {
        $guestBookModel = new GuestBookEntryModel($id);
        $guestBookModel->fetch();
        return json_encode($guestBookModel->toArray());
    }

    public static function outputEntryById($id) {
        $guestBookModel = new GuestBookEntryModel($id);
        $guestBookModel->fetch();
        return json_encode($guestBookModel->toArray());
        // view
    }

    public static function outputAllEntries() {
        $guestBookModel = new GuestBookModel();
        $guestBookEntries = $guestBookModel->getAllEntries($doFetch = true);

        $smarty = new Smarty;
        $smarty->setCacheDir('/tmp/cache');
        $smarty->setCompileDir('/tmp/templates_c');
        // $smarty->setCacheDir(ROOT_DIRECTORY . '/tmp/cache');
        // $smarty->setCompileDir(ROOT_DIRECTORY . '/tmp/templates_c');
        $smarty->setTemplateDir(SOURCE_DIRECTORY . '/View/templates');
        $smarty->assign("entries", array_map(
                function($guestBookEntry) {
                    return $guestBookEntry->toArray();
                }, $guestBookEntries
            )
        );
        return $smarty->display('index.tpl');
    }

    

    public static function getGuestBookEntryById($guestBookEntryId) {
        // $stmt = Database::prepare("INSERT INTO entries (authorId, title, createDate) VALUES (1, :title, NOW())");
        // $stmt->bindParam(':title', $guestBookData['title']);
        // $stmt->execute();
    }
}