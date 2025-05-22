<?php

namespace App\Services\Dashboard;

use App\Repositories\Blog\BlogRepository;
use LaravelEasyRepository\Service;
use App\Repositories\Dashboard\DashboardRepository;
use App\Repositories\Faq\FaqRepository;
use App\Repositories\Template\TemplateRepository;
use App\Repositories\Transaction\TransactionRepository;
use App\Repositories\Tutorial\TutorialRepository;
use App\Repositories\User\UserRepository;
use Exception;

class DashboardServiceImplement extends Service implements DashboardService{

     /**
     * don't change $this->mainRepository variable name
     * because used in extends service class
     */
     protected $userRepository;
     protected $transactionRepository;
     protected $blogRepository;
     protected $tutorialRepository;
     protected $templateRepository;
     protected $faqRepository;
    public function __construct(UserRepository $userRepository,TransactionRepository $transactionRepository,BlogRepository $blogRepository,TutorialRepository $tutorialRepository,TemplateRepository $templateRepository,FaqRepository $faqRepository)
    {
      $this->userRepository = $userRepository;
      $this->transactionRepository = $transactionRepository;
      $this->blogRepository = $blogRepository;
      $this->tutorialRepository = $tutorialRepository;
      $this->templateRepository = $templateRepository;
      $this->faqRepository = $faqRepository;
    }

    // Define your custom methods :)
    public function coundDataDashboard(){
        try {

            $users =  $this->userRepository->getAllUserData([],0,0,"id","ASC",[]);
            $transactions = $this->transactionRepository->getAllData([],0,0,"id","ASC",[]);
            $blogs = $this->blogRepository->getAllData([],0,0,"id","ASC",[]);
            $tutorials = $this->tutorialRepository->getAllData([],0,0,"id","ASC",[]);
            $templates = $this->templateRepository->getAllData([],0,0,"id","ASC",[]);
            $faqs = $this->faqRepository->getAllData([],0,0,"id","ASC",[]);

            $arrayCount = [
                'user' => $users->count(),
                'transaction' => $transactions->count(),
                'blog' => $blogs->count(),
                'tutorial' => $tutorials->count(),
                'template' => $templates->count(),
                'faq' => $faqs->count()
            ];

            return [
                'code' => 200,
                'status' => true,
                'data' => ['count' => $arrayCount],
                'message' => 'Success Get All Count Data'
            ];

        } catch (\Throwable $th) {
            throw new Exception($th->getMessage(), 500);
        }
    }

}
