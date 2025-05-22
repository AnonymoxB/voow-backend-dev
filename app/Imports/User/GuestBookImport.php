<?php

namespace App\Imports\User;

use App\Models\InvitationGuestBook;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Str;

class GuestBookImport implements ToModel, WithHeadingRow
{

    private $invitationId;

    public function __construct(int $invitationId)
    {
        $this->invitationId = $invitationId;
    }

    public function model(array $row)
    {
        InvitationGuestBook::updateOrCreate(
            [
                'invitation_id' => $this->invitationId,
                'name' => $row['name'],
                'phone_number' => $row['phone_number'],
            ],
            [
                'address' => $row['address'],
                'slug' => Str::slug($row['name']),
                'is_scan' => 0,
                'qrcode' => Str::uuid()->toString()
            ]
        );
    }
}
