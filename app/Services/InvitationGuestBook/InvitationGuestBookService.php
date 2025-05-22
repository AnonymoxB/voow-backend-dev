<?php

namespace App\Services\InvitationGuestBook;

use LaravelEasyRepository\BaseService;

interface InvitationGuestBookService extends BaseService{

    // Write something awesome :)
    public function getAllGuestBook($request);
    public function showGuestBook($request);
    public function storeGuestBook($request);
    public function updateGuestBook($request);
    public function deleteGuestBook($request);
    public function importFromExcelGuestBook($request);
    public function exportToExcelGuestBook($request);
    public function getGuestBookData($request);
    public function scanGuestBook($request);
    public function getDataScanGuestBook($request);
    public function getDataMessage($request);
    public function sendMessage($request);
}
