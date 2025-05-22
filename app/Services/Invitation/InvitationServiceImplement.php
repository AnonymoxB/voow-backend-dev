<?php

namespace App\Services\Invitation;

use LaravelEasyRepository\Service;
use App\Repositories\Invitation\InvitationRepository;
use App\Repositories\InvitationDetail\InvitationDetailRepository;
use App\Repositories\Template\TemplateRepository;
use App\Repositories\Music\MusicRepository;
use App\Repositories\UserPackage\UserPackageRepository;
use Exception;
use Faker\Factory as Faker;
use Illuminate\Support\Str;

class InvitationServiceImplement extends Service implements InvitationService
{

    /**
     * don't change $this->mainRepository variable name
     * because used in extends service class
     */
    protected $mainRepository;
    protected $userPackageRepository;
    protected $templateRepository;
    protected $invitationDetailRepository;
    protected $musicRepository;
    public function __construct(InvitationRepository $mainRepository, UserPackageRepository $userPackageRepository, TemplateRepository $templateRepository, InvitationDetailRepository $invitationDetailRepository, MusicRepository $musicRepository)
    {
        $this->mainRepository = $mainRepository;
        $this->userPackageRepository = $userPackageRepository;
        $this->templateRepository = $templateRepository;
        $this->invitationDetailRepository = $invitationDetailRepository;
        $this->musicRepository = $musicRepository;
    }

    public function getMyInvitation($request)
    {
        try {
            $where = [['user_id', auth()->user()->id], ['parent_id', '=', null]];

            $myInvitation = $this->mainRepository->getAllData($where, 0, 0, "id", "ASC", ['template', 'template.templateCategory', 'invitationEn']);

            return [
                'code' => 200,
                'status' => true,
                'data' => $myInvitation,
                'message' => 'Success Get My Invitation'
            ];
        } catch (\Throwable $th) {
            throw new Exception($th->getMessage(), 500);
        }
    }

    public function showMyInvitation($request)
    {
        try {

            $showMyInvitation = $this->mainRepository->whereFirst([[
                'user_id', auth()->user()->id
            ], [
                'uuid', $request
            ]], [
                'detail', 'images'
            ]);

            return [
                'code' => 200,
                'status' => true,
                'data' => $showMyInvitation,
                'message' => 'Success Show My Invitation'
            ];
        } catch (\Throwable $th) {
            throw new Exception($th->getMessage(), 500);
        }
    }




    public function createInvitation($request)
    {
        try {
            $userId = auth()->user()->id;
            $userPremium = $this->userPackageRepository->checkUserIsPremium($userId);

            if (!$userPremium) {
                return [
                    'code' => 400,
                    'status' => false,
                    'data' => ['music' => $request->all()],
                    'message' => 'User Not Premium, Upgrade To Premium First !'
                ];
            }

            $faker = Faker::create('id_ID');
            $male = $faker->unique()->firstName("male");
            $female = $faker->unique()->firstName("female");
            $linkSlug =  Str::slug($male . " " . $female);

            $requestInvitation = [
                'uuid' => Str::uuid(),
                'user_id' => $userId,
                'template_id' => $request->template_id,
                'link_slug' => $linkSlug,
                'title' => 'Undangan Pernikahan',
                'description' => 'Tanpa Mengurangi Rasa Hormat. Kami Bermaksud Mengundang Bapak/Ibu/Saudara/i, Pada Acara Pernikahan Kami',
                'lang' => 'ID',
                'status' => 'Draft'
            ];


            $invitationCreate = $this->mainRepository->create($requestInvitation);


            $requestInvitationEnglish = [
                'user_id' => $userId,
                'template_id' => $request->template_id,
                'link_slug' => $linkSlug,
                'title' => 'Wedding Invitation',
                'description' => '',
                'lang' => 'EN',
                'status' => 'Draft',
                'parent_id' =>  $invitationCreate->id
            ];

            $this->mainRepository->create($requestInvitationEnglish);

            //create invitation detail
            $requestDataInvitationDetail = [
                'invitation_id' => $invitationCreate->id,
            ];

            $this->invitationDetailRepository->create($requestDataInvitationDetail);

            return [
                'code' => 200,
                'status' => true,
                'data' => ['invitation' => $requestInvitation],
                'message' => 'Success Create Invitation'
            ];
        } catch (\Throwable $th) {
            throw new Exception($th->getMessage(), 500);
        }
    }


    public function getMySetting($request)
    {
        try {

            $getMySettingInvitation = $this->mainRepository->findWith($request, ['invitationEn', 'music'], [[
                'user_id', auth()->user()->id
            ]]);


            return [
                'code' => 200,
                'status' => true,
                'data' => $getMySettingInvitation ?? [],
                'message' => 'Success Get Setting My Invitation'
            ];
        } catch (\Throwable $th) {
            throw new Exception($th->getMessage(), 500);
        }
    }

    public function updateSetting($request)
    {
        try {
            if ($request->lang == "ID") {
                $where = [
                    ['id', $request->invitation_id],
                    ['user_id', auth()->user()->id],
                    ['lang', $request->lang]
                ];
            } else {
                $where = [
                    ['parent_id', $request->invitation_id],
                    ['user_id', auth()->user()->id],
                    ['lang', $request->lang]
                ];
            }

            $findInvitation = $this->mainRepository->whereFirst($where, []);

            if (!$findInvitation) {
                return [
                    'code' => 404,
                    'status' => false,
                    'data' => [],
                    'message' => 'Invitation Not Found'
                ];
            }

            if ($request->has('invitation_link')) {
                //check if invitation_link is exists
                $findValidationLink = $this->mainRepository->whereGet([[
                    'link_slug', $request->invitation_link
                ], [
                    'parent_id', null
                ]]);

                if ($findValidationLink->count() > 1) {
                    return [
                        'code' => 400,
                        'status' => false,
                        'data' => [],
                        'message' => 'Invitation Link Has been Taken'
                    ];
                }

                if ($findValidationLink->count() > 1) {
                    if ($findValidationLink->first()->link_slug != $findInvitation->link_slug) {
                        return [
                            'code' => 400,
                            'status' => false,
                            'data' => [],
                            'message' => 'Invitation Link Has been Taken'
                        ];
                    }
                }
            }


            $requestUpdateSetting = [
                'link_slug' => $request->invitation_link ?? $findInvitation->link_slug,
                'title' => $request->title,
                'description' => $request->description,
                'event_date' => $request->event_date,
                'event_time' => $request->event_time,
                'address' => $request->address,
                'time_zone' => $request->time_zone
            ];

            $this->mainRepository->update($findInvitation->id, $requestUpdateSetting);

            return [
                'code' => 200,
                'status' => true,
                'data' => $request->all(),
                'message' => 'Success Update Setting Invitation'
            ];
        } catch (\Throwable $th) {
            throw new Exception($th->getMessage(), 500);
        }
    }

    public function updateImageSetting($request){
        try {

            $where = [
                ['id', $request->invitation_id],
                ['user_id', auth()->user()->id],
            ];

            $findInvitation = $this->mainRepository->whereFirst($where, []);

            if (!$findInvitation) {
                return [
                    'code' => 404,
                    'status' => false,
                    'data' => [],
                    'message' => 'Invitation Not Found'
                ];
            }

            $findInvitation->update([
                'image_share' => $request->image_share
            ]);

            return [
                'code' => 200,
                'status' => true,
                'data' => $request->all(),
                'message' => 'Success Update Image Share Setting Invitation'
            ];

        } catch (\Throwable $th) {
            throw new Exception($th->getMessage(), 500);
        }
    }

    public function updateTemplate($request)
    {
        try {

            $userId =  auth()->user()->id;
            $UserPackage = $this->userPackageRepository->find($userId);
            $findTemplate = $this->templateRepository->find($request->template_id);

            if ($findTemplate) {
                if ($findTemplate->type === "Premium" && !$UserPackage) {
                    return [
                        'code' => 400,
                        'status' => false,
                        'data' => [],
                        'message' => 'User Not Using Premium Template'
                    ];
                }
            } else {
                return [
                    'code' => 404,
                    'status' => false,
                    'data' => [],
                    'message' => 'Template Not Found'
                ];
            }

            $invitation =  $this->mainRepository->whereFirst([[
                'id', $request->invitation_id,
            ], ['user_id', $userId], ['parent_id', null]]);

            if (!$invitation) {
                return [
                    'code' => 404,
                    'status' => false,
                    'data' => [],
                    'message' => 'Invitation Not Found'
                ];
            }

            $invitation->update([
                'template_id' => $findTemplate->id
            ]);


            return [
                'code' => 200,
                'status' => true,
                'data' => $invitation,
                'message' => 'Success Update Template My Invitation'
            ];
        } catch (\Throwable $th) {
            throw new Exception($th->getMessage(), 500);
        }
    }

    public function updateMusic($request)
    {
        try {
            $findMusic = $this->musicRepository->find($request->music_id);
            if (!$findMusic) {
                return [
                    'code' => 404,
                    'status' => false,
                    'data' => [],
                    'message' => 'Music Not Found'
                ];
            }

            $userId =  auth()->user()->id;

            $invitation =  $this->mainRepository->whereFirst([[
                'id', $request->invitation_id,
            ], ['user_id', $userId], ['parent_id', null]]);

            if (!$invitation) {
                return [
                    'code' => 404,
                    'status' => false,
                    'data' => [],
                    'message' => 'Invitation Not Found'
                ];
            }

            $invitation->update([
                'music_id' => $findMusic->id,
                'music_active' => $request->music_active
            ]);


            return [
                'code' => 200,
                'status' => true,
                'data' => $invitation,
                'message' => 'Success Update Music My Invitation'
            ];
        } catch (\Throwable $th) {
            throw new Exception($th->getMessage(), 500);
        }
    }

    public function updateStatusInvitation($request)
    {
        try {
            $userId = auth()->user()->id;

            $invitation =  $this->mainRepository->whereFirst([[
                'id', $request->invitation_id,
            ], ['user_id', $userId], ['parent_id', null]]);

            if (!$invitation) {
                return [
                    'code' => 404,
                    'status' => false,
                    'data' => [],
                    'message' => 'Invitation Not Found'
                ];
            }

            if ($request->status == 0) {
                $status = "Draft";
            } else {
                $status = "Publish";
            }

            $invitation->update([
                'status' => $status
            ]);

            return [
                'code' => 200,
                'status' => true,
                'data' => $invitation,
                'message' => 'Success Update Status My Invitation'
            ];
        } catch (\Throwable $th) {
            throw new Exception($th->getMessage(), 500);
        }
    }
}
