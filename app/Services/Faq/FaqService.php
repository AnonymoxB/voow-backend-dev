<?php

namespace App\Services\Faq;

use LaravelEasyRepository\BaseService;

interface FaqService extends BaseService{

    public function getAllFaq($request);
    public function storeFaq($request);
    public function updateFaq($request);
    public function showFaq(int $id);
    public function deleteFaq(int $id);
}
