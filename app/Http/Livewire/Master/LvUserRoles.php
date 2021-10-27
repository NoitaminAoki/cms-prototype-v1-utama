<?php

namespace App\Http\Livewire\Master;

use Livewire\Component;
use Spatie\Permission\Models\Role;
use App\Models\{
    User,
};

class LvUserRoles extends Component
{
    protected $listeners = [
        'evSetRole' => 'setRole',
    ];

    public $user =[
        'id' => null,
        'name' => null,
        'email' => null,
    ];
    
    public $selected_role_id;

    public function render()
    {
        $data['users'] = User::with('roles')->get();
        $data['roles'] = Role::query()
        ->where('guard_name', 'web')
        ->get();

        return view('livewire.master.lv-user-roles')
        ->with($data)
        ->layout('layouts.dashboard.main');
    }

    public function setUser($id)
    {
        $user = User::findOrFail($id);
        
        $this->user['id']       = $user->id;
        $this->user['name']     = $user->name;
        $this->user['email']    = $user->email;
        if (!empty($user->roles[0])) {
            $this->selected_role_id = $user->roles[0]->id;
            $this->dispatchBrowserEvent('select2:set', ['selector' => '#select_role', 'value' => $user->roles[0]->id]);
        }
    }
    
    public function setRole($id)
    {
        $this->selected_role_id = $id;
    }
    
    public function updateUserRole()
    {
        $user = User::findOrFail($this->user['id']);
        
        $role = Role::where('id', $this->selected_role_id)->get();
        $user->syncRoles($role);
        
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        
        $this->resetInput();
        return $this->dispatchBrowserEvent('notification:success', ['title' => 'Success!', 'message' => 'Successfully updating data.']);
    }
    
    public function resetInput()
    {
        $this->user =[
            'id' => null,
            'name' => null,
            'email' => null,
        ];
        $this->reset('selected_role_id');
    }
}
