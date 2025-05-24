<?php

use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProfileController as AdminProfileController;
use App\Http\Controllers\Blog\BlogController;
use App\Http\Controllers\BlogCategory\BlogCategoryController;
use App\Http\Controllers\paket\PaketController;
use App\Http\Controllers\Faq\FaqController;
use App\Http\Controllers\GuestBook\GuestBookController;
use App\Http\Controllers\Invitation\InvitationController;
use App\Http\Controllers\Music\MusicController;
use App\Http\Controllers\Package\PackageController;
use App\Http\Controllers\Payment\PaymentController;
use App\Http\Controllers\Rsvp\RsvpController;
use App\Http\Controllers\Template\TemplateController;
use App\Http\Controllers\TemplateCategory\TemplateCategoryController;
use App\Http\Controllers\Transaction\TransactionController;
use App\Http\Controllers\Tutorial\TutorialController;
use App\Http\Controllers\TutorialCategory\TutorialCategoryController;
use App\Http\Controllers\User\AuthController;
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\UserController;

use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::get('/paket',[PaketController::class,'show']);

Route::prefix('v1')->group(function () {


    Route::prefix('callback/transaction')->group(function () {
        Route::post('xendit', [TransactionController::class, 'transactionCallback']);

    });

    Route::prefix('auth')->group(function () {

        Route::post('login', [AuthController::class, 'login']);
        Route::post('register', [AuthController::class, 'register']);

        Route::prefix('social')->group(function () {
            Route::get('login/{provider}', [AuthController::class, 'socialLogin']);
            Route::get('login/{provider}/callback', [AuthController::class, 'socialLoginCallback']);
        });


        Route::prefix('admin')->group(function () {
            Route::post('login', [AdminAuthController::class, 'login']);
            Route::get('logout', [AdminAuthController::class, 'logout'])->middleware(['auth:sanctum']);
        });
    });

    Route::prefix('blog')->group(function () {
        Route::get('', [BlogController::class, 'frontIndex']);
        Route::get('show/{slug}', [BlogController::class, 'frontShow']);

        //category
        Route::prefix('category')->group(function () {
            Route::get('', [BlogCategoryController::class, 'frontIndex']);
            Route::get('/{slug}', [BlogCategoryController::class, 'frontShow']);
        });
    });



    Route::prefix('tutorial')->group(function () {

        Route::get('', [TutorialController::class, 'frontIndex']);
        Route::get('show/{slug}', [TutorialController::class, 'frontShow']);

        Route::prefix('category')->group(function () {
            Route::get('', [TutorialCategoryController::class, 'frontIndex']);
            Route::get('{slug}', [TutorialCategoryController::class, 'frontShow']);
        });
    });

    //faq
    Route::prefix('faq')->group(function () {
        Route::get('', [FaqController::class, 'frontIndex']);
    });


    //package
    Route::prefix('package')->group(function () {
        Route::get('', [PackageController::class, 'frontIndex']);
    });

    //template
    Route::prefix('template')->group(function () {
        Route::get('', [TemplateController::class, 'frontIndex']);

        Route::prefix('category')->group(function () {
            Route::get('', [TemplateCategoryController::class, 'frontIndex']);
            Route::get('{slug}', [TemplateCategoryController::class, 'frontShow']);
        });
    });

    //guest
    Route::prefix('guest')->group(function () {
        Route::post('store/rsvp', [RsvpController::class, 'storeRsvp']);


    });



    Route::middleware(['auth:sanctum'])->group(function () {

        //for user
        Route::middleware(['isUser'])->group(function () {

            Route::prefix('dashboard')->group(function () {
                Route::get('', [UserDashboardController::class, 'getCountDashboard']);
            });

            Route::prefix('user')->group(function () {
                Route::prefix('profile')->group(function () {
                    Route::get('', [ProfileController::class, 'profile']);
                    Route::post('update', [ProfileController::class, 'updateProfile']);
                });
                Route::post('update-password', [ProfileController::class, 'updatePassword']);
            });

            Route::post('pay', [PaymentController::class, 'pay']);

            Route::prefix('transaction')->group(function () {
                Route::get('', [TransactionController::class, 'getMyTransactionIndex']);
            });

            Route::prefix('music')->group(function () {
                Route::get('', [MusicController::class, 'frontIndex']);
            });

            Route::prefix('invitation')->group(function () {
                Route::get('my', [InvitationController::class, 'myInvitation']);
                Route::get('my/show/{id}', [InvitationController::class, 'showMyInvitation']);
                Route::post('create', [InvitationController::class, 'createInvitation']);
                Route::get('setting/{id}', [InvitationController::class, 'getMySetting']);
                Route::post('update-setting',[InvitationController::class,'updateSetting']);
                Route::post('update-setting-image',[InvitationController::class,'updateImageSetting']);
                Route::post('update-template',[InvitationController::class,'updateTemplate']);
                Route::post('update-music',[InvitationController::class,'updateMusic']);
                Route::post('update-invitation',[InvitationController::class,'updateInvitation']);
                Route::post('update-status',[InvitationController::class,'updateStatusInvitation']);

                Route::prefix('{invitation_id}/rsvp')->group(function () {
                    Route::get('', [GuestBookController::class, 'index']);
                    Route::post('store', [GuestBookController::class, 'store']);
                    Route::get('show/{id}', [GuestBookController::class, 'show']);
                    Route::post('update/{id}', [GuestBookController::class, 'update']);
                    Route::get('delete/{id}', [GuestBookController::class, 'delete']);

                    Route::post('import-excel',[GuestBookController::class,'importFromExcel']);
                    Route::get("export-excel",[GuestBookController::class,'exportFromExcel']);


                });

                Route::prefix('{invitation_id}/guest-book')->group(function () {
                    Route::get('', [GuestBookController::class, 'getGuestBookData']);
                });

                Route::prefix('{invitation_id}/scan')->group(function () {
                    Route::get('', [GuestBookController::class, 'getScanGuestBookData']);
                    Route::get('/{qrcode}', [GuestBookController::class, 'scanGuestBookData']);
                });

                Route::prefix('{invitation_id}/send-message')->group(function () {
                    Route::get('', [GuestBookController::class, 'getSendMessage']);
                    Route::post('/{id}', [GuestBookController::class, 'sendMessage']);
                });



                Route::post('upload-image', [InvitationController::class, 'uploadImageInvitation']);

            });
        });


        //for admin
        Route::middleware(['isAdmin'])->group(function () {
        
            Route::prefix('admin')->group(function () {

                    Route::prefix('paket')->group(function() {
                         Route::get('',[PaketController::class,'show']);
                     });

                Route::get("test", function () {
                    return "testting";
                });

                //dashboard
                Route::prefix('dashboard')->group(function () {
                    Route::get("count", [DashboardController::class, 'getAllCountData']);
                });
                ///profile
                Route::prefix('profile')->group(function () {
                    Route::get("my", [AdminProfileController::class, 'my']);
                });


                //faq
                Route::prefix('faq')->group(function () {
                    Route::get('', [FaqController::class, 'adminIndex']);
                    Route::post('store', [FaqController::class, 'store']);
                    Route::get('show/{id}', [FaqController::class, 'show']);
                    Route::post('update', [FaqController::class, 'update']);
                    Route::post('delete', [FaqController::class, 'delete']);
                });

                //blog
                Route::prefix('blog')->group(function () {

                    Route::get('', [BlogController::class, 'adminIndex']);
                    Route::get('show/{slug}', [BlogController::class, 'adminShow']);
                    Route::post('store', [BlogController::class, 'adminStore']);
                    Route::post('update', [BlogController::class, 'adminUpdate']);
                    Route::post('delete', [BlogController::class, 'adminDelete']);


                    //category
                    Route::prefix('category')->group(function () {
                        Route::get('', [BlogCategoryController::class, 'adminIndex']);
                        Route::get('show/{slug}', [BlogCategoryController::class, 'adminShow']);
                        Route::post('store', [BlogCategoryController::class, 'store']);
                        Route::post('update', [BlogCategoryController::class, 'update']);
                        Route::post('delete', [BlogCategoryController::class, 'delete']);
                    });
                });

                //tutorial
                Route::prefix('tutorial')->group(function () {

                    Route::get('', [TutorialController::class, 'adminIndex']);
                    Route::get('show/{slug}', [TutorialController::class, 'adminShow']);
                    Route::post('store', [TutorialController::class, 'adminStore']);
                    Route::post('update', [TutorialController::class, 'adminUpdate']);
                    Route::post('delete', [TutorialController::class, 'adminDelete']);

                    //category
                    Route::prefix('category')->group(function () {
                        Route::get('', [TutorialCategoryController::class, 'adminIndex']);
                        Route::get('show/{slug}', [TutorialCategoryController::class, 'adminShow']);
                        Route::post('store', [TutorialCategoryController::class, 'store']);
                        Route::post('update', [TutorialCategoryController::class, 'update']);
                        Route::post('delete', [TutorialCategoryController::class, 'delete']);
                    });
                });

                //user
                Route::prefix('user')->group(function () {
                    Route::get('', [UserController::class, 'listUser']);
                });

                //transaction
                Route::prefix('transaction')->group(function () {
                    Route::get('', [TransactionController::class, 'adminIndex']);
                });

                //music
                Route::prefix('music')->group(function () {
                    Route::post('store', [MusicController::class, 'storeAdmin']);
                });
            });
        });
    });
});
