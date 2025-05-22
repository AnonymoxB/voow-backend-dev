<?php

namespace App\Services\Faq;

use LaravelEasyRepository\Service;
use App\Repositories\Faq\FaqRepository;
use Exception;

class FaqServiceImplement extends Service implements FaqService
{

    /**
     * don't change $this->mainRepository variable name
     * because used in extends service class
     */
    protected $mainRepository;

    public function __construct(FaqRepository $mainRepository)
    {
        $this->mainRepository = $mainRepository;
    }

    // Define your custom methods :)

    public function getAllFaq($request)
    {
        try {
            $limit = $request->limit ?? 0;
            $sort_column = $request->sort_column ?? "id";
            $sort_order = $request->sort_order ?? "ASC";
            $offset = $request->offset ?? 0;
            $with = [];
            $where = [];

            $request->status ? array_push($where, [
                ['status' => $request->status]
            ]) : [];

            $faqData =  $this->mainRepository->getAllData($where, $limit, $offset, $sort_column, $sort_order, $with);


            return $faqData;
        } catch (\Throwable $th) {
            throw new Exception($th->getMessage(), 500);
        }
    }

    public function storeFaq($request)
    {
        try {

            $faqCreate = $this->mainRepository->create([
                'question' => $request->question,
                'answer' => $request->answer,
                'lang' => $request->lang,
                'status' => $request->status ?? "Draft",
                'parent_id' => $request->parent_id
            ]);

            return [
                'code' => 200,
                'status' => true,
                'data' => ['faq' => $faqCreate],
                'message' => 'Success Create FAQ'
            ];
        } catch (\Throwable $th) {
            throw new Exception($th->getMessage(), 500);
        }
    }


    public function updateFaq($request)
    {
        try {

            $faqUpdate = $this->mainRepository->find($request->id);

            if (!$faqUpdate) {
                return [
                    'code' => 404,
                    'status' => false,
                    'data' => null,
                    'message' => 'Faq Tidak Ditemukan'
                ];
            }

            $faqUpdate->update([
                'question' => $request->question,
                'answer' => $request->answer,
                'lang' => $request->lang,
                'status' => $request->status
            ]);

            return [
                'code' => 200,
                'status' => true,
                'data' => ['faq' => $faqUpdate],
                'message' => 'Success Update FAQ'
            ];

        } catch (\Throwable $th) {
            throw new Exception($th->getMessage(), 500);
        }
    }

    public function showFaq(int $id)
    {
        try {
            $showFaq = $this->mainRepository->find($id);

            if (!$showFaq) {
                return [
                    'code' => 404,
                    'status' => false,
                    'data' => null,
                    'message' => 'Faq Tidak Ditemukan'
                ];
            }

            return [
                'code' => 200,
                'status' => true,
                'data' => ['faq' => $showFaq],
                'message' => 'Success Show FAQ'
            ];

        } catch (\Throwable $th) {
            throw new Exception($th->getMessage(), 500);
        }
    }

    public function deleteFaq(int $id)
    {
        try {

            $showFaq = $this->mainRepository->find($id);

            if (!$showFaq) {
                return [
                    'code' => 404,
                    'status' => false,
                    'data' => null,
                    'message' => 'Faq Tidak Ditemukan'
                ];
            }

            $deleteFaq = $this->mainRepository->delete($id);

            return [
                'code' => 200,
                'status' => true,
                'data' => ['faq' => $deleteFaq],
                'message' => 'Success Delete FAQ'
            ];
        } catch (\Throwable $th) {
            throw new Exception($th->getMessage(), 500);
        }
    }
}
