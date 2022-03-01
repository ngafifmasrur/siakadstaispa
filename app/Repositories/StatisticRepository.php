<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\Role;

class StatisticRepository
{
    /**
     * Get all resources.
     */
    public function getMain()
    {
        return [
            'total-users' => [
                'label'     => 'Jumlah pengguna',
                'value'     => User::count(),
                'icon'      => 'icon-people',
                'color'     => 'primary'
            ],
            'total-roles' => [
                'label'     => 'Jumlah peran',
                'value'     => Role::count(),
                'icon'      => 'icon-puzzle',
                'color'     => 'warning'
            ],
            'memory-usage' => [
                'label'     => 'Pemakaian memori',
                'value'     => $this->getServerMemoryUsage(),
                'icon'      => 'icon-speedometer',
                'color'     => 'success'
            ],
            'deleted-users' => [
                'label'     => 'Pengguna yang dihapus',
                'value'     => User::onlyTrashed()->count(),
                'icon'      => 'icon-trash',
                'color'     => 'danger'
            ]
        ];
    }

    /**
     * Get memory usage.
     */
    public function getServerMemoryUsage(){
        $mem = memory_get_usage(true);
            
        if ($mem < 1024) {
            
            $$memory = $mem .' B'; 
            
        } elseif ($mem < 1048576) {
            
            $memory = round($mem / 1024, 2) .' KB';
            
        } else {
            
            $memory = round($mem / 1048576, 2) .' MB';
            
        }
        
        return $memory;
    }
}
