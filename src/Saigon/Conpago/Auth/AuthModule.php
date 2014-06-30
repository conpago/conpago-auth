<?php
	/**
	 * Created by PhpStorm.
	 * User: Bartosz Gołek
	 * Date: 2014-06-30
	 * Time: 23:04
	 */

	namespace Saigon\Conpago\Auth;

	use Saigon\Conpago\DI\IContainerBuilder;
	use Saigon\Conpago\IModule;

	class AuthModule implements IModule
	{
		public function build(IContainerBuilder $builder)
		{
			$builder
				->registerType('Saigon\Conpago\Helpers\Session')
				->asA('Saigon\Conpago\ISession');

			$builder
				->registerType('Saigon\Conpago\Core\SessionManager')
				->asA('Saigon\Conpago\ISessionManager');
		}
	}