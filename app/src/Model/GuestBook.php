<?php


namespace mmmga\GuestBook\Model;

use PDO;
use mmmga\GuestBook\Database;
use mmmga\GuestBook\Model\GuestBookEntry;

class GuestBook {

    private $entries = [];

    public function getAllEntries(bool $doFetch = false) {
        if($doFetch) {
            $this->fetchAllEntries();
        }
        return $this->entries;
    }

    public function fetchAllEntries() {
        $stmt = Database::prepare('SELECT * FROM entries');
        $stmt->execute();
        return array_map(
            function(Array $rawEntryObj) {
                $tmpEntry = new GuestBookEntry($rawEntryObj['id']);
                $tmpEntry->setEntryData($rawEntryObj);
                $this->entries[] = $tmpEntry;
            }, $stmt->fetchAll(PDO::FETCH_ASSOC)
        );
    }

    public function generateNewEntry() {
        
    }
}