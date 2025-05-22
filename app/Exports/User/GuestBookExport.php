<?php

namespace App\Exports\User;

use App\Models\InvitationGuestBook;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class GuestBookExport implements FromCollection,WithColumnWidths,WithStyles,WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */


    private $invitationId;

    public function __construct(int $invitationId)
    {
        $this->invitationId = $invitationId;
    }

    public function collection()
    {
        return InvitationGuestBook::select('name','phone_number','address')->where('invitation_id', $this->invitationId)->get();

    }

    public function headings(): array
    {
        return [
            'Name',
            'Phone Number',
            'Address'
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 55,
            'B' => 55,
            'C' => 55,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1    => ['font' => ['bold' => true,'size' => 20,'calibri' => true]],
        ];
    }
}
