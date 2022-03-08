<?php

return [
    'name' => 'Web',

    'app' => [
    	'name' => env('APP_NAME'),
    ],

    'head' => [
    	'title'	=> env('APP_NAME'),
    ],

    'navbar' => [
        'brand_long' => 'MA Sunan Pandanaran',
        'brand' => 'MASPA'
    ],

    'footer' => [
    	'footer'  => env('APP_NAME'),
    ],

    'references' => [
        'sexes'     => \App\Models\UserProfile::$sex,
        'bloods'    => \App\Models\UserProfile::$blood,
        'is_deads'    => \App\Models\UserProfile::$is_dead,
        'biologicals'    => \App\Models\UserProfile::$biological,
        'countries' => \App\Models\References\Country::all(),
        'grades' => \App\Models\References\Grade::all(),
        'salaries' => \App\Models\References\Salary::all(),
        'employments' => \App\Models\References\Employment::all(),
        'organization_types' => \App\Models\References\OrganizationType::all(),
        'organization_positions' => \App\Models\References\OrganizationPosition::all(),
        'achievement_types' => \App\Models\References\AchievementType::all(),
        'achievement_nums' => \App\Models\References\AchievementNum::all(),
        'territories' => \App\Models\References\Territory::all(),
    ],

    'models' => [
        'districts'  => new \App\Models\References\ProvinceRegencyDistrict(),
    ],
];
