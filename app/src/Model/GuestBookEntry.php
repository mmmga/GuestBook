<?php

namespace mmmga\GuestBook\Model;

use PDO;
use mmmga\GuestBook\Database;

class GuestBookEntry {

    private $id;
    private $title;
    private $authorId;
    private $createDate;
    private $childs = [];

    function __construct($entryId) {
        $this->id = $entryId;
    }

    public function fetch() {
        $stmt = Database::prepare('SELECT * FROM entries WHERE id = ?');
        $stmt->execute([$this->id]);
        $entryRawData = $stmt->fetchObject();
        $this->setEntryData([
            'title' => $entryRawData->title,
            'authorId' => $entryRawData->authorId,
            'createDate' => $entryRawData->createDate    
        ]);
    }

    public function toArray() {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'authorId' => $this->authorId,
            'createDate' => $this->createDate
        ];
    } 

    public function getTitle() {
        return $this->title;
    }

    public function setEntryData($entryData) {
        $this->setTitle($entryData['title']);
        $this->setAuthorId($entryData['authorId']);
        $this->setCreateDate($entryData['createDate']);
    }

    public function setTitle($title) {
        $this->title = $title;
    }
    public function setAuthorId($authorId) {
        $this->authorId = $authorId;
    }
    public function setCreateDate($createDate) {
        $this->createDate = $createDate;
    }

    public static function generateNewEntry(Array $guestBookData) {
        $guestBookData['createDate'] = date('Y-m-d H:i:s');
        $guestBookData['authorId'] = 1;

        $stmt = Database::prepare("INSERT INTO entries (authorId, title, createDate) VALUES (:authorId, :title, :createDate)");
        $stmt->bindParam(':title', $guestBookData['title']);
        $stmt->bindParam(':createDate', $guestBookData['createDate']);
        $stmt->bindParam(':authorId', $guestBookData['authorId']);
        $stmt->execute();

        $newEntryId = Database::lastInsertId();
        $guestBookEntry = new GuestBookEntry($newEntryId);
        $guestBookEntry->setEntryData($guestBookData);
        return $guestBookEntry;
    }
}