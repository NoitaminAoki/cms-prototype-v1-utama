<?php

namespace App\Http\Livewire\Master;

use Livewire\Component;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Arr;
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
    
    public $permissions;
    public $total_permission_page;
    public $permission_page = 1;
    public $offset_permission = 0;
    public $limit_permission = 0;
    public $permission_search;
    public $permission_ids = [];

    public $selectedAll;
    
    public function mount()
    {
        $this->limit_permission = 15;

        $tester = ['1', '2', '3', '4'];
        $tester2 = ['1', '2', '3'];
        $count_all = count($tester2);
        $count_same = count(array_intersect($tester, $tester2));
        // dd($tester, $tester2, $count_all, $count_same, $count_all == $count_same);
    }

    public function render()
    {
        $data['roles'] = Role::query()
        ->with('permissions')
        ->where('guard_name', 'web')
        ->get();
        $this->permissions = [];
        
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
            $this->permissions = $query_permission->when($this->offset_permission, function ($query, $offset) use ($limit)
            {
                return $query->offset($offset);
            })
            ->limit($limit)->get();

            $this->checkValue();
        }
        
        return view('livewire.master.lv-roles')
        ->with($data)
        ->layout('layouts.dashboard.main');
    }

    public function updatedPermissionSearch($value)
    {
        $this->permission_page = 1;
    }

    public function updatedSelectedAll($value)
    {
        if($value) {
            $merge_collection = collect($this->permission_ids)->merge($this->permissions->pluck('id'));
            $this->permission_ids = array_map('strval', $merge_collection->unique()->toArray());
            return $this->dispatchBrowserEvent('console:log', [ 'value' => ['merge' => $merge_collection, 'origin' => $this->permission_ids]]);
        } else {
            $this->permission_ids = array_values(array_diff($this->permission_ids, $this->permissions->pluck('id')->toArray()));
            return $this->dispatchBrowserEvent('console:log', [ 'value' => ['origin' => $this->permission_ids]]);
        }
    }

    public function checkValue()
    {
        $string_val = array_map('strval', $this->permissions->pluck('id')->toArray());
        $count_all = count($string_val);
        $count_same = count(array_intersect($this->permission_ids, $string_val));
        $contains = ($count_all == $count_same);
        $this->selectedAll = $contains;
        return $this->dispatchBrowserEvent('console:log', [ 'value' => $contains]);
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
