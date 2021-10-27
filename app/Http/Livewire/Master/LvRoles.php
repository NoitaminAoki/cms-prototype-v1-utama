<?php

namespace App\Http\Livewire\Master;

use Livewire\Component;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Helpers\Converter;

class LvRoles extends Component
{
    public $control_tabs = [
        'view' => true,
        'add' => false,
    ];
    public $role = [
        'name' => null,
    ];
    
    public $list_items = [];
    
    public $total_permission_page;
    public $permission_page = 1;
    public $offset_permission = 0;
    public $limit_permission = 0;
    public $permission_search;
    public $permission_ids = [];
    
    public function mount()
    {
        $this->limit_permission = 15;
    }

    public function render()
    {
        $data['roles'] = Role::query()
        ->with('permissions')
        ->where('guard_name', 'web')
        ->get();
        $data['permissions'] = [];
        
        if ($this->control_tabs['add']) {
            $query_permission = Permission::when($this->permission_search, function ($query, $permission_search)
            {
                return $query->where('name', 'like', '%'.$permission_search.'%');
            })
            ->where('guard_name', 'web');
            
            $limit = $this->limit_permission;
            $total_data = $query_permission->count();
            $total_page = Converter::totalPage($total_data, $limit);
            $this->total_permission_page = $total_page;
            $this->offset_permission = Converter::pageToOffset($this->permission_page, $limit);
            $data['permissions'] = $query_permission->when($this->offset_permission, function ($query, $offset) use ($limit)
            {
                return $query->offset($offset);
            })
            ->limit($limit)->get();
        }
        
        return view('livewire.master.lv-roles')
        ->with($data)
        ->layout('layouts.dashboard.main');
    }

    public function updatedPermissionSearch($value)
    {
        $this->permission_page = 1;
    }
    
    public function showRoles()
    {
        $this->control_tabs = [
            'view' => true,
            'add' => false,
        ];
    }
    public function showAddRole()
    {
        $this->control_tabs = [
            'view' => false,
            'add' => true,
        ];
    }

	public function goToPage($page)
	{
		if($page < 1) {
			$page = 1;
		}
		$this->permission_page = $page;
	}

    public function addPermissionToList()
    {
        $this->list_items = Permission::select('id', 'name')
        ->whereIn('id', $this->permission_ids)
        ->get()
        ->toArray();

        return $this->dispatchBrowserEvent('modal:close');
    }

    public function deletePermission($id)
    {
        $removed_permission_ids = [];
        $list_items = [];
        foreach ($this->list_items as $value) {
            if($value['id'] <> $id) {
                $removed_permission_ids[] = $value['id'];   
                $list_items[] = $value;
            }
        }
        $this->permission_ids = $removed_permission_ids;
        $this->list_items = $list_items;

        // dd($this->permission_ids);
    }

    public function resetInput()
    {
        $this->list_items = [];
        $this->permission_ids = [];
        $this->role['name'] = null;
        $this->permission_page = 1;
        $this->reset([
            'permission_search',
        ]);
    }

    public function addRole()
    {
        $this->validate([
            'role.name' => 'required|string',
        ]);
        $permissions = Permission::whereIn('id', $this->permission_ids)->get();        
        // dd($permissions);
        $role = Role::create(['name' => $this->role['name'], 'guard_name' => 'web']);
        $role->syncPermissions($permissions);
        
        $this->resetInput();
        $this->showRoles();
        return $this->dispatchBrowserEvent('notification:success', ['title' => 'Success!', 'message' => 'Successfully adding data.']);

    }
}
