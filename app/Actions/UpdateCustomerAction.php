<?php

declare(strict_types=1);

namespace App\Actions;

use App\Models\Customer;

/**
 * class UpdateCustomerAction
 *
 * @package App\Actions
 */
class UpdateCustomerAction
{
    /**
     * @param \App\Models\Customer $customer
     * @param array $data
     * @param array|null $groups
     * @return bool
     */
    public function run(Customer $customer, array $data, ?array $groups = null): bool
    {
        $success = $customer->fillAndSave($data);

        if($success && $groups) {
            $customer->syncGroups(array_column($groups, 'name'));
            $customer->load('groups');
        }

        return $success;
    }
}
