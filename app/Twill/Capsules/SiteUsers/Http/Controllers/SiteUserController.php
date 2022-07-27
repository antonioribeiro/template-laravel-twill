<?php

namespace App\Twill\Capsules\SiteUsers\Http\Controllers;

use A17\Twill\Http\Controllers\Admin\ModuleController as BaseModuleController;

/**
 * @property \App\Twill\Capsules\SiteUsers\Repositories\SiteUserRepository $repository
 */
class SiteUserController extends BaseModuleController
{
    protected $moduleName = 'siteUsers';

    protected $titleColumnKey = 'email';

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
        'revisions' => true,
    ];

    protected $indexColumns = [
        'email' => [
            'title' => 'Email',
            'field' => 'email',
            'sort' => true,
        ],

        'name' => [
            'title' => 'Name',
            'field' => 'name',
            'sort' => true,
        ],

        'verified' => [
            'title' => 'Email verified',
            'field' => 'emailIsVerifiedString',
            'sort' => true,
        ],

        'has_password' => [
            'title' => 'Has password',
            'field' => 'hasPassword',
            'sort' => true,
        ],
    ];

    /**
     * @param \Illuminate\Database\Eloquent\Collection $items
     * @param array $scopes
     * @return array
     */
    protected function getIndexTableMainFilters($items, $scopes = [])
    {
        $statusFilters = parent::getIndexTableMainFilters($items, $scopes);

        $statusFilters[] = [
            'name' => 'Logins',
            'slug' => 'hasLogin',
            'number' => $this->repository->countLogins(),
        ];

        return $statusFilters;
    }

    /**
     * @param array $prependScope
     * @return array
     */
    protected function getIndexData($prependScope = [])
    {
        $scope = $this->getRequestFilters()['status'] ?? null;

        if ($scope == 'hasLogin') {
            $prependScope += [$scope => true];
        }

        return parent::getIndexData($prependScope);
    }
}
