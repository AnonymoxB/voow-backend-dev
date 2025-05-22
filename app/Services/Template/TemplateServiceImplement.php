<?php

namespace App\Services\Template;

use LaravelEasyRepository\Service;
use App\Repositories\Template\TemplateRepository;
use Exception;

class TemplateServiceImplement extends Service implements TemplateService{

     /**
     * don't change $this->mainRepository variable name
     * because used in extends service class
     */
     protected $mainRepository;

    public function __construct(TemplateRepository $mainRepository)
    {
      $this->mainRepository = $mainRepository;
    }

    // Define your custom methods :)
    public function getAllTemplate($request){
        try {

            $limit = $request->limit ?? 10;
            $sort_column = $request->sort_column ?? "id";
            $sort_order = $request->sort_order ?? "ASC";
            $offset = $request->offset ?? 0;
            $where = [];
            $with = ['templateCategory'];

            $request->status ? array_push($where, [
                ['status' => $request->status]
            ]) : [];

            if ($request->has('search')) {
                $search = $request->search;
                $blogData = $this->mainRepository->searchData($where, $limit, $offset, $sort_column, $sort_order, 'title', $search, $with);
            } else {
                $blogData =  $this->mainRepository->getAllData($where, $limit, $offset, $sort_column, $sort_order, $with);
            }

            return $blogData;
        } catch (\Throwable $th) {
            throw new Exception($th->getMessage(), 500);
        }
    }
}
