<?php

namespace App\Twill\Capsules\SiteUsers\Http\Controllers;

use A17\Twill\Http\Controllers\Admin\ModuleController as BaseModuleController;

class SiteUserController extends BaseModuleController
{
    protected $moduleName = 'siteUsers';

    protected $titleColumnKey = 'name';

    protected $indexOptions = [
        'create' => false,
        'edit' => true,
        'publish' => true,
        'bulkPublish' => true,
        'feature' => false,
        'bulkFeature' => false,
        'restore' => true,
        'bulkRestore' => true,
        'forceDelete' => true,
        'bulkForceDelete' => true,
        'delete' => true,
        'duplicate' => false,
        'bulkDelete' => true,
        'reorder' => false,
        'permalink' => false,
        'bulkEdit' => true,
        'editInModal' => false,
        'skipCreateModal' => false,
    ];

    protected $indexColumns = [
        'name' => [
            'title' => 'Name',
            'field' => 'name',
            'sort' => true,
        ],

        'email' => [
            'title' => 'Email',
            'field' => 'email',
            'sort' => true,
        ],

        'verified' => [
            'title' => 'Verified',
            'field' => 'emailIsVerifiedString',
            'sort' => true,
        ],
    ];
}
