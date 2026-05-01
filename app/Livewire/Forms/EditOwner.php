<?php

namespace App\Livewire\Forms;

use App\Helper\Files;
use App\Models\ApartmentManagement;
use App\Models\Floor;
use App\Models\Tower;
use App\Models\ParkingManagementSetting;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use App\Models\Role;
use App\Models\User;
use Livewire\WithFileUploads;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class EditOwner extends Component
{
    use LivewireAlert, WithFileUploads;

    public $roles;
    public $name;
    public $email;
    public $phone;
    public $role;
    public $status;
    public $profilePhoto;
    public $hasNewPhoto = false;
    public $userId;
    public $user;

    public $towers = [];
    public $floors = [];
    public $apartments = [];
    public $selectedTower;
    public $selectedFloor;
    public $selectedApartment;
    public $selectedApartmentsArray = [];

    public function mount()
    {
        $this->roles = Role::where('name', 'Owner_' . society()->id)->first();
        $this->towers = Tower::all();

        $this->userId = $this->user->id;
        $this->name = $this->user->name;
        $this->email = $this->user->email;
        $this->phone = $this->user->phone_number;
        $this->status = $this->user->status;

        $this->selectedApartmentsArray = ApartmentManagement::where('user_id', $this->userId)->pluck('id')->toArray();
    }

    public function updatedSelectedTower()
    {
        $this->selectedFloor = '';
        $this->selectedApartment = '';
        $this->floors = Floor::where('tower_id', $this->selectedTower)->get();
        $this->apartments = collect([]);
    }

    public function updatedSelectedFloor()
    {
        if ($this->selectedTower && $this->selectedFloor) {
            $this->selectedApartment = '';
            $this->apartments = ApartmentManagement::where('tower_id', $this->selectedTower)
                ->where('floor_id', $this->selectedFloor)
                ->where(function ($query) {
                    $query->where('status', 'not_sold')
                        ->orWhere('user_id', $this->userId);
                })
                ->get();
        } else {
            $this->apartments = collect([]);
        }
    }

    public function updatedSelectedApartment()
    {
        if ($this->selectedApartment && !in_array($this->selectedApartment, $this->selectedApartmentsArray)) {
            $apartment = ApartmentManagement::find($this->selectedApartment);
            if ($apartment) {
                $this->selectedApartmentsArray[] = $this->selectedApartment;
                $this->selectedApartment = '';
            }
        }
    }

    public function removeApartment($apartmentId)
    {
        $this->selectedApartmentsArray = array_values(array_filter($this->selectedApartmentsArray, function ($id) use ($apartmentId) {
            return $id != $apartmentId;
        }));
    }

    public function updateOwner()
    {
        $this->validate([
            'name' => 'required',
            'email' => 'required|email:rfc,strict|unique:users,email,' . $this->userId,
            'status' => 'required',
            'selectedApartmentsArray' => 'required|array|min:1',
            'phone' => 'nullable|string|max:20',
        ], [
            'selectedApartmentsArray.required' => __('messages.apartmentRequired'),
            'selectedApartmentsArray.min' => __('messages.apartmentRequired'),
        ]);

        $this->user->name = $this->name;
        $this->user->email = $this->email;
        $this->user->phone_number = $this->phone;
        $this->user->status = $this->status;
        $this->user->role_id = $this->roles->id;

        if ($this->profilePhoto instanceof TemporaryUploadedFile) {
            $filename = Files::uploadLocalOrS3($this->profilePhoto, User::FILE_PATH . '/', width: 150, height: 150);
            $this->user->profile_photo_path = $filename;
            $this->hasNewPhoto = false;
        }
        $this->user->save();
        $role = Role::find($this->roles->id);
        $this->user->syncRoles([$role->name]);

        ApartmentManagement::where('user_id', $this->userId)->update(['user_id' => null, 'status' => 'not_sold']);

        foreach ($this->selectedApartmentsArray as $apartmentId) {
            $apartment = ApartmentManagement::find($apartmentId);
            $apartment->user_id = $this->userId;
            $apartment->status = 'occupied';
            $apartment->save();
        }

        $this->dispatch('hideEditOwner');

        $this->alert('success', __('messages.ownerUpdated'));
    }

    public function removeProfilePhoto()
    {
        $this->profilePhoto = null;
        $this->user->profile_photo_path = null;
        $this->user->save();
        $this->dispatch('photo-removed');
    }

    public function render()
    {
        return view('livewire.forms.edit-owner');
    }
}
