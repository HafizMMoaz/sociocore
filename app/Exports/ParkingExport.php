<?php

namespace App\Exports;

use App\Models\ParkingManagementSetting;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Style;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ParkingExport implements WithMapping, FromCollection, WithHeadings, WithStyles, ShouldAutoSize
{

    use Exportable;
    protected $search;
    protected $filterApartments;

    public function __construct($search, $filterApartments = [])
    {
        $this->search = $search;
        $this->filterApartments = $filterApartments;
    }

    public function headings(): array
    {
        return [
            __('modules.settings.societyParkingCode'),
            __('modules.settings.societyApartmentNumber'),
        ];
    }

    public function map($parking): array
    {
        return [
            $parking->parking_code,
            $parking->apartmentManagement->first()->apartment_number ?? '--',
        ];
    }

    public function defaultStyles(Style $defaultStyle)
    {
        return $defaultStyle
            ->getFont()
            ->setName('Arial');
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle($sheet->calculateWorksheetDimension())->applyFromArray([
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_LEFT,
            ],
        ]);

        return [
            1 => [
                'font' => [
                    'bold' => true,
                    'name' => 'Arial',
                ],
                'fill' => [
                    'fillType'   => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'f5f5f5'],
                ],
            ],
        ];
    }

    public function collection()
    {
        $query = ParkingManagementSetting::query();

        $loggedInUser = user()->id;
        if (!user_can('Show Parking')) {
            $query->whereHas('apartmentManagement', function ($q) use ($loggedInUser) {
                $q->where('user_id', $loggedInUser);
            });
        }

        if (!empty($this->search)) {
            $query->where(function($q) {
                $q->whereHas('apartmentManagement', function ($query) {
                    $query->where('apartment_number', 'like', '%'.$this->search.'%');
                })
                ->orWhere('parking_code', 'like', '%' . $this->search . '%');
            });
        }
        
        if (!empty($this->filterApartments)) {
            $query->join('apartment_parking', 'parking_managements.id', '=', 'apartment_parking.parking_id')
                ->join('apartment_managements', 'apartment_parking.apartment_management_id', '=', 'apartment_managements.id')
                ->whereIn('apartment_managements.id', $this->filterApartments)
                ->select('parking_managements.*');
        }
        return $query->get();
    }

}
