<?php

namespace App\Services\TemplateCategory;

use LaravelEasyRepository\Service;
use App\Repositories\TemplateCategory\TemplateCategoryRepository;
use Exception;

class TemplateCategoryServiceImplement extends Service implements TemplateCategoryService{

     /**
     * don't change $this->mainRepository variable name
     * because used in extends service class
     */
     protected $mainRepository;

    public function __construct(TemplateCategoryRepository $mainRepository)
    {
      $this->mainRepository = $mainRepository;
    }

    // Define your custom methods :)
    public function getAllTemplateCategory($request){
        try {

            $limit = $request->limit ?? 10;
            $sort_column = $request->sort_column ?? "id";
            $sort_order = $request->sort_order ?? "ASC";
            $offset = $request->offset ?? 0;
            $with = [];
            $where = [];

            if ($request->has('search')) {
                $search = $request->search;
                $templateCategoryData = $this->mainRepository->searchData($where, $limit, $offset, $sort_column, $sort_order, 'title', $search, $with);
            } else {
                $templateCategoryData =  $this->mainRepository->getAllData($where, $limit, $offset, $sort_column, $sort_order, $with);
            }

            return $templateCategoryData;
        } catch (\Throwable $th) {
            throw new Exception($th->getMessage(), 500);
        }
    }

    public function showTemplateCategory($slug){
        try {
            $where = [['slug', $slug]];
            $templateCategoryData = $this->mainRepository->whereFirst($where, ['template','template.templateCategory']);
            return $templateCategoryData;

        } catch (\Throwable $th) {
            throw new Exception($th->getMessage(), 500);
        }
    }
}
