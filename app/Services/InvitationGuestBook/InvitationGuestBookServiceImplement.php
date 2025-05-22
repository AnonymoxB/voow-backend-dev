<?php

namespace App\Services\InvitationGuestBook;

use App\Exports\User\GuestBookExport;
use App\Imports\User\GuestBookImport;
use App\Repositories\Invitation\InvitationRepository;
use LaravelEasyRepository\Service;
use App\Repositories\InvitationGuestBook\InvitationGuestBookRepository;
use App\Repositories\InvitationRsvp\InvitationRsvpRepository;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class InvitationGuestBookServiceImplement extends Service implements InvitationGuestBookService
{

    /**
     * don't change $this->mainRepository variable name
     * because used in extends service class
     */
    protected $mainRepository;
    protected $invitationRepository;
    protected $invitationRsvpRepository;
    public function __construct(InvitationGuestBookRepository $mainRepository, InvitationRepository $invitationRepository, InvitationRsvpRepository $invitationRsvpRepository)
    {
        $this->mainRepository = $mainRepository;
        $this->invitationRepository = $invitationRepository;
        $this->invitationRsvpRepository = $invitationRsvpRepository;
    }

    // Define your custom methods :)
    public function getAllGuestBook($request)
    {
        try {

            $limit = $request->limit ?? 10;
            $sort_column = $request->sort_column ?? "id";
            $sort_order = $request->sort_order ?? "ASC";
            $offset = $request->offset ?? 0;
            $with = [];
            $where = [
                ["invitation_id", $request->invitation_id]
            ];

            if ($request->has('search')) {
                $search = $request->search;
                $guestBook = $this->mainRepository->searchData($where, $limit, $offset, $sort_column, $sort_order, 'name', $search, $with);
            } else {
                $guestBook =  $this->mainRepository->getAllData($where, $limit, $offset, $sort_column, $sort_order, $with);
            }


            return [
                'code' => 200,
                'status' => true,
                'data' => $guestBook,
                'message' => 'Success Get My Guest Book'
            ];
        } catch (\Throwable $th) {
            throw new Exception($th->getMessage(), 500);
        }
    }

    public function showGuestBook($request)
    {
        try {
            $where = [['invitation_id', $request->invitation_id], ['id', $request->id]];
            $guestBook = $this->mainRepository->whereFirst($where);
            if (!$guestBook) {
                return [
                    'code' => 404,
                    'status' => false,
                    'data' => [],
                    'message' => 'Guest Book Not Found'
                ];
            }
            return [
                'code' => 200,
                'status' => true,
                'data' => $guestBook,
                'message' => 'Success Show My Guest Book'
            ];
        } catch (\Throwable $th) {
            throw new Exception($th->getMessage(), 500);
        }
    }

    public function storeGuestBook($request)
    {
        try {

            $findInvitation = $this->invitationRepository->find($request->invitation_id);
            if (!$findInvitation) {
                return [
                    'code' => 404,
                    'status' => false,
                    'data' => [],
                    'message' => 'Invitation Not Found'
                ];
            }

            $uniqueRandomString = Str::uuid()->toString();

            $guestBookCreate = $this->mainRepository->create([
                'invitation_id' => $findInvitation->id,
                'name' => $request->name,
                'phone_number' => $request->phone_number,
                'slug' => Str::slug($request->name),
                'address' => $request->address,
                'qrcode' => $uniqueRandomString
            ]);


            return [
                'code' => 200,
                'status' => true,
                'data' => ['guest_book' => $guestBookCreate],
                'message' => 'Success Create Guest Book'
            ];
        } catch (\Throwable $th) {
            throw new Exception($th->getMessage(), 500);
        }
    }


    public function updateGuestBook($request)
    {
        try {
            $where = [['invitation_id', $request->invitation_id], ['id', $request->id]];
            $guestBook = $this->mainRepository->whereFirst($where);
            if (!$guestBook) {
                return [
                    'code' => 404,
                    'status' => false,
                    'data' => [],
                    'message' => 'Guest Book Not Found'
                ];
            }

            $guestBook->update([
                'name' => $request->name,
                'slug' => Str::slug($request->name),
                'phone_number' => $request->phone_number,
                'address' => $request->address,
            ]);

            return [
                'code' => 200,
                'status' => true,
                'data' => ['guest_book' => $request->all()],
                'message' => 'Success Update Guest Book'
            ];
        } catch (\Throwable $th) {
            throw new Exception($th->getMessage(), 500);
        }
    }

    public function deleteGuestBook($request)
    {
        try {
            $where = [['invitation_id', $request->invitation_id], ['id', $request->id]];
            $guestBook = $this->mainRepository->whereFirst($where);

            if (!$guestBook) {
                return [
                    'code' => 404,
                    'status' => false,
                    'data' => [],
                    'message' => 'Guest Book Not Found'
                ];
            }

            $guestBook->delete();

            return [
                'code' => 200,
                'status' => true,
                'data' => ['guest_book' => $guestBook],
                'message' => 'Success Delete Guest Book'
            ];
        } catch (\Throwable $th) {
            throw new Exception($th->getMessage(), 500);
        }
    }

    public function importFromExcelGuestBook($request)
    {
        try {

            Excel::import(new GuestBookImport($request->invitation_id), $request->file);

            return [
                'code' => 200,
                'status' => true,
                'message' => 'Import Data Berhasil',
                'data' => [
                    'invitation_id' => $request->invitation_id
                ]
            ];
        } catch (\Throwable $th) {
            throw new Exception($th->getMessage(), 500);
        }
    }

    public function exportToExcelGuestBook($request)
    {
        try {
            $user = Auth::user()->name ?? "user";
            $fileName = $user . "-GuestBookExport.xlsx";
            return Excel::download(new GuestBookExport($request->invitation_id), $fileName);
        } catch (\Throwable $th) {
            throw new Exception($th->getMessage(), 500);
        }
    }

    public function getGuestBookData($request)
    {
        try {
            $where = [['invitation_id', $request->invitation_id]];
            $guestBook = $this->mainRepository->whereGet($where, ['rsvp']);
            $notConfirm =  $guestBook->where('rsvp', null)->count();

            $present = $this->mainRepository->whereRelationGet([['invitation_id', $request->invitation_id], ['is_scan', 1]], 'rsvp', [[
                'is_present', 1
            ]])->count();

            $wantToPresent = $this->mainRepository->whereRelationGet($where, 'rsvp', [[
                'is_present', 1
            ]])->count();
            $notPresent = $this->mainRepository->whereRelationGet($where, 'rsvp', [[
                'is_present', 0
            ]])->count();

            $data =  [
                'present' => $present,
                'want_to_attend' => $wantToPresent,
                'not_present' => $notPresent,
                'not_confirm' => $notConfirm,
                'guest_book' => $guestBook
            ];

            return [
                'code' => 200,
                'status' => true,
                'data' => $data,
                'message' => 'Success Get Data Guest Book'
            ];
        } catch (\Throwable $th) {
            throw new Exception($th->getMessage(), 500);
        }
    }


    public function getDataScanGuestBook($request)
    {
        try {
            $where = [['invitation_id', $request->invitation_id], [
                'is_scan', 1
            ]];
            $data = $this->mainRepository->whereSelectGet(['name'], $where);
            return [
                'code' => 200,
                'status' => true,
                'data' => $data,
                'message' => 'Success Get Data Guest Book'
            ];
        } catch (\Throwable $th) {
            throw new Exception($th->getMessage(), 500);
        }
    }

    public function scanGuestBook($request)
    {
        try {
            $where = [['invitation_id', $request->invitation_id], [
                'qrcode', $request->qrcode
            ]];
            $guestBook = $this->mainRepository->whereFirst($where);
            if (!$guestBook) {
                return [
                    'code' => 404,
                    'status' => false,
                    'data' => $guestBook,
                    'message' => 'Guest Book Not Found'
                ];
            }

            $guestBook->update([
                'is_scan' => 1
            ]);

            return [
                'code' => 200,
                'status' => true,
                'message' => 'Scan Successfully',
                'data' => $guestBook->name
            ];
        } catch (\Throwable $th) {
            throw new Exception($th->getMessage(), 500);
        }
    }


    public function getDataMessage($request)
    {
        try {
            $where = [['invitation_id', $request->invitation_id]];
            $guestBook = $this->mainRepository->whereSelectGet(['id','name','phone_number','status_message'],$where);

            return [
                'code' => 200,
                'status' => true,
                'message' => 'Get Data Message Successfully',
                'data' => $guestBook
            ];
        } catch (\Throwable $th) {
            throw new Exception($th->getMessage(), 500);
        }
    }


    public function sendMessage($request)
    {
        try {
            $where = [['invitation_id', $request->invitation_id], [
                'id', $request->id
            ]];
            $guestBook = $this->mainRepository->whereFirst($where);
            if (!$guestBook) {
                return [
                    'code' => 404,
                    'status' => false,
                    'data' => $guestBook,
                    'message' => 'Guest Book Not Found'
                ];
            }

            $message = " __INI TEST DEVELOPMENT__
Undangan Aqiqah & Tasmiyah

Kepada Yth *{nama_tamu}*
_Bismillahirrahmanirrahim_ Assalamu’alaikum Wr. Wb. Tanpa Mengurangi Rasa Hormat. Kami Bermaksud Mengundang Bapak/Ibu/Saudara/i, Pada Acara Tasyakkuran Aqiqah Anak Kami : *{nama_anak}*
Hari/Tgl : *{hari_tanggal}*
Alamat : *{alamat}*
Undangan lebih lengkap klik link dibawah ini {link_undangan}
Merupakan Suatu Kebahagiaan Dan Kehormatan Bagi Kami, Apabila Bapak/Ibu/Saudara/i, Berkenan Hadir Untuk Memberikan Do'a Kepada Anak Kami. Atas Kehadiran dan Do'a Kami Ucapkan Terimakasih.
_Wassalamu’alaikum Wr. Wb._";

            $curl = curl_init();
            $token = "pL0rBxDqPSNwyXY2lBPROMqAh4d5g3eQFLtbVqarEVCOk4RKSGW5RHoroEKrHsYD";
            $data = [
                'phone' => $guestBook->phone_number,
                'message' => $message,
            ];
            curl_setopt(
                $curl,
                CURLOPT_HTTPHEADER,
                array(
                    "Authorization: $token",
                )
            );
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
            curl_setopt($curl, CURLOPT_URL,  "https://jogja.wablas.com/api/send-message");
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
            $result = curl_exec($curl);
            curl_close($curl);
            $responseSendMessage = json_decode($result);

            if($responseSendMessage->status == false){
                $guestBook->update([
                    'status_message' => 0
                ]);
            }else{
                $guestBook->update([
                    'status_message' => 1
                ]);
            }

            return [
                'code' => 200,
                'status' => true,
                'message' => 'Send Message Successfully',
                'data' => $guestBook->name
            ];
        } catch (\Throwable $th) {
            throw new Exception($th->getMessage(), 500);
        }
    }
}
