<?php

namespace App\Livewire\Forms;

use App\Helper\Files;
use App\Models\ApartmentManagement;
use Carbon\Carbon;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Role;
use App\Models\User;

class EditTenant extends Component
{
    use LivewireAlert, WithFileUploads;

    public $roles;
    public $role;
    public $name;
    public $email;
    public $phone;
    public $date;
    public $contract_start_date = null;
    public $contract_end_date = null;
    public $rent_amount;
    public $rent_billing_cycle;
    public $status;
    public $move_in_date = null;
    public $move_out_date = null;
    public $profilePhoto;
    public $document;
    public $familyMembers = [];
    public $apartmentRented = [];
    public $tenant;
    public $user;
    public $userId;
    public $selectedApartment;

    public function mount()
    {
        if ($this->tenant && $this->tenant->user) {
            $this->userId = $this->tenant->user->id;
            $this->name = $this->tenant->user->name;
            $this->email = $this->tenant->user->email;
            $this->phone = $this->tenant->user->phone_number;
            $this->role = $this->tenant->user->role_id;
        }

        $this->roles = Role::where('name', 'Tenant_' . society()->id)->first();

        $tenantApartments = $this->tenant->apartments;
        if ($tenantApartments->isNotEmpty()) {
            $selectedApartment = $tenantApartments->first();

            $this->selectedApartment = $selectedApartment->id;
            $this->contract_start_date = $selectedApartment->pivot->contract_start_date ?? null;
            $this->contract_end_date = $selectedApartment->pivot->contract_end_date ?? null;
            $this->move_in_date = $selectedApartment->pivot->move_in_date ?? null;
            $this->move_out_date = $selectedApartment->pivot->move_out_date ?? null;
            $this->rent_amount = $selectedApartment->pivot->rent_amount ?? null;
            $this->rent_billing_cycle = $selectedApartment->pivot->rent_billing_cycle ?? null;
            $this->status = $selectedApartment->pivot->status ?? null;
        }

        $this->apartmentRented = ApartmentManagement::whereNotIn('status', ['occupied', 'rented'])
            ->orWhere('id', $this->selectedApartment)
            ->get();
        $this->familyMembers = [];
        $this->loadAvailableTimeSlots();
    }

    public function loadAvailableTimeSlots()
    {
        if (empty($this->contract_start_date)) {
            $this->contract_start_date = null;
        }

        if (empty($this->contract_end_date)) {
            $this->contract_end_date = null;
        }
    }

    public function updateTenant()
    {
        $formattedContractStartDate = $this->contract_start_date ? Carbon::parse($this->contract_start_date)->format('Y-m-d') : null;
        $formattedContractEndDate = $this->contract_end_date ? Carbon::parse($this->contract_end_date)->format('Y-m-d') : null;
        $formattedMoveInDate = $this->move_in_date ? Carbon::parse($this->move_in_date)->format('Y-m-d') : null;
        $formattedMoveOutDate = $this->move_out_date ? Carbon::parse($this->move_out_date)->format('Y-m-d') : null;

        // Validate the input data
        $this->validate([
            'name' => 'required',
            'email' => 'required|email:rfc,strict|unique:users,email,' . $this->userId,
            'phone' => 'nullable|string|max:20',
            'rent_amount' => 'nullable|numeric|min:0',
            'selectedApartment' => 'required',
            'contract_start_date' => 'required|date',
            'contract_end_date' => 'required|date|after:contract_start_date',
            'move_in_date' => [
                'nullable',
                'date',
                function ($attribute, $value, $fail) use ($formattedContractStartDate, $formattedContractEndDate, $formattedMoveInDate) {
                    if ($formattedContractStartDate && $formattedMoveInDate && $formattedMoveInDate < $formattedContractStartDate) {
                        $fail(__('messages.moveInDateAfterError'));
                    }

                    if ($formattedContractEndDate && $formattedMoveInDate && $formattedMoveInDate > $formattedContractEndDate) {
                        $fail(__('messages.moveOutDateBeforeError'));
                    }
                }
            ],
            'move_out_date' => [
                'nullable',
                'date',
                'after:move_in_date',
                function ($attribute, $value, $fail) use ($formattedContractStartDate, $formattedContractEndDate, $formattedMoveOutDate) {
                    if ($value && !$this->move_in_date) {
                        $fail(__('messages.moveOutDateRequiresMoveInDate'));
                    }
                    if ($formattedContractStartDate && $formattedMoveOutDate && $formattedMoveOutDate < $formattedContractStartDate) {
                        $fail(__('messages.moveOutDateAfterError'));
                    }
                    if ($formattedContractEndDate && $formattedMoveOutDate && $formattedMoveOutDate > $formattedContractEndDate) {
                        $fail(__('messages.moveOutDateBeforeError'));
                    }
                }
            ],
        ]);

        $this->tenant->user->name = $this->name;
        $this->tenant->user->email = $this->email;
        $this->tenant->user->phone_number = $this->phone;
        $this->tenant->user->role_id = $this->roles->id;

        if ($this->profilePhoto) {
            $filename = Files::uploadLocalOrS3($this->profilePhoto, User::FILE_PATH . '/', width: 150, height: 150);
            $this->tenant->user->profile_photo_path = $filename;
        }

        $this->tenant->user->save();

        $role = Role::find($this->roles->id);
        $this->tenant->user->syncRoles([$role->name]);

        $existingRelationship = $this->tenant->apartments()->where('apartment_tenant.apartment_id', $this->selectedApartment)->first();
        if ($existingRelationship) {
            $this->tenant->apartments()->updateExistingPivot($this->selectedApartment, [
                'contract_start_date' => $formattedContractStartDate,
                'contract_end_date' => $formattedContractEndDate,
                'rent_amount' => $this->rent_amount,
                'rent_billing_cycle' => $this->rent_billing_cycle ?: 'monthly',
                'status' => $this->status ?: 'current_resident',
                'move_in_date' => $formattedMoveInDate,
                'move_out_date' => $formattedMoveOutDate,
            ]);
        } else {
            $this->tenant->apartments()->attach($this->selectedApartment, [
                'contract_start_date' => $formattedContractStartDate,
                'contract_end_date' => $formattedContractEndDate,
                'rent_amount' => $this->rent_amount,
                'rent_billing_cycle' => $this->rent_billing_cycle ?: 'monthly',
                'status' => $this->status ?: 'current_resident',
                'move_in_date' => $formattedMoveInDate,
                'move_out_date' => $formattedMoveOutDate,
            ]);
        }

        ApartmentManagement::where('id', $this->selectedApartment)->update(['status' => 'rented']);

        $this->dispatch('hideEditTenant');

        $this->alert('success', __('messages.tenantUpdated'));
    }

    public function removeProfilePhoto()
    {
        $this->profilePhoto = null;
        $this->tenant->user->profile_photo_path = null;
        $this->tenant->user->save();
        $this->dispatch('photo-removed');
    }

    public function render()
    {
        return view('livewire.forms.edit-tenant');
    }
}
