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
				->registerType('Saigon\Conpago\Auth\Session')
				->asA('Saigon\Conpago\Auth\Contract\ISession');

			$builder
				->registerType('Saigon\Conpago\Auth\SessionManager')
				->asA('Saigon\Conpago\Auth\Contract\ISessionManager');
		}
	}