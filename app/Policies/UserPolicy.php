<?php
/**
 * Invoice Ninja (https://invoiceninja.com)
 *
 * @link https://github.com/invoiceninja/invoiceninja source repository
 *
 * @copyright Copyright (c) 2019. Invoice Ninja LLC (https://invoiceninja.com)
 *
 * @license https://opensource.org/licenses/AAL
 */

namespace App\Policies;

use App\Models\Client;
use App\Models\CompanyUser;
use App\Models\User;

/**
 * Class UserPolicy
 * @package App\Policies
 */
class UserPolicy extends EntityPolicy
{
	/**
	 *  Checks if the user has create permissions
	 *  
	 * @param  User $user
	 * @return bool
	 */
	public function create(User $user) : bool
	{

		return $user->isAdmin() || $user->hasPermission('create_user') || $user->hasPermission('create_all');

	}


	/*
	*
	* We need to override as User does not have the company_id property!!!!!
	*
	* We use the CompanyUser table as a proxy
	*/
	public function edit(User $user, $user_entity) : bool
	{
		$company_user = CompanyUser::whereUserId($user_entity->id)->company()->first();

		return ($user->isAdmin() && $company_user);
    
	}

}
