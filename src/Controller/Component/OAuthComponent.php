<?php

/**
 * CakePHP OAuth Server Plugin
 *
 * This is the main component.
 *
 * It provides:
 *	- Cakey interface to the OAuth2-php library
 *	- AuthComponent like action allow/deny's
 *	- Easy access to user associated to an access token
 *	- More!?
 *
 * @author Thom Seddon <thom@seddonmedia.co.uk>
 * @see https://github.com/thomseddon/cakephp-oauth-server
 *
 */

App::uses('Component', 'Controller');
App::uses('Router', 'Routing');
App::uses('Security', 'Utility');
App::uses('Hash', 'Utility');
App::uses('AuthComponent', 'Controller');



App::import('Vendor', 'oauth2-php/lib/OAuth2');
App::import('Vendor', 'oauth2-php/lib/IOAuth2Storage');
App::import('Vendor', 'oauth2-php/lib/IOAuth2RefreshTokens');
App::import('Vendor', 'oauth2-php/lib/IOAuth2GrantUser');
App::import('Vendor', 'oauth2-php/lib/IOAuth2GrantCode');

class OAuthComponent extends Component implements IOAuth2Storage, IOAuth2RefreshTokens, IOAuth2GrantUser, IOAuth2GrantCode {

	// the other component your component uses
	public $components = array('ApiCommon');
/**
 * AccessToken object.
 *
 * @var object
 */
	public $AccessToken;

/**
 * Array of allowed actions
 *
 * @var array
 */
	public $allowedActions = array('*');
	public $denyedActions = array();

/**
 * An array containing the model and fields to authenticate users against
 *
 * Inherits theses defaults:
 *
 * $this->OAuth->authenticate = array(
 *	'userModel' => 'User',
 *	'fields' => array(
 *		'username' => 'username',
 *		'password' => 'password'
 *	)
 * );
 *
 * Which can be overridden in your beforeFilter:
 *
 * $this->OAuth->authenticate = array(
 *	'fields' => array(
 *		'username' => 'email'
 *	)
 * );
 *
 *
 * $this->OAuth->authenticate
 *
 * @var array
 */
	public $authenticate;

/**
 * Defaults for $authenticate
 *
 * @var array
 */
	protected $_authDefaults = array(
		'userModel' => 'User',
		'fields' => array('username' => 'username', 'password' => 'password')
		);

/**
 * AuthCode object.
 *
 * @var object
 */
	public $AuthCode;

/**
 * Clients object.
 *
 * @var object
 */
	public $Client;

/**
 * Array of globally supported grant types
 *
 * By default = array('authorization_code', 'refresh_token', 'password');
 * Other grant mechanisms are not supported in the current release
 *
 * @var array
 */
	public $grantTypes = array('authorization_code', 'refresh_token', 'password');

/**
 * OAuth2 Object
 *
 * @var object
 */
	public $OAuth2;

/**
 * RefreshToken object.
 *
 * @var object
 */
	public $RefreshToken;

/**
 * User object
 *
 * @var object
 */
	public $User;

/**
 * Static storage for current user
 *
 * @var array
 */
	protected $_user = false;

/**
 * Constructor - Adds class associations
 *
 * @see OAuth2::__construct().
 */
	public function __construct(ComponentCollection $collection, $settings = array()) {
		parent::__construct($collection, $settings);
		$this->OAuth2 = new OAuth2($this);
		$this->OAuth2->setVariable('access_token_lifetime',864000); // 10 days
		$this->AccessToken = ClassRegistry::init(array('class' => 'AccessToken', 'alias' => 'AccessToken'));
		$this->AuthCode = ClassRegistry::init(array('class' => 'AuthCode', 'alias' => 'AuthCode'));
		$this->Client = ClassRegistry::init(array('class' => 'Client', 'alias' => 'Client'));
		$this->RefreshToken = ClassRegistry::init(array('class' => 'RefreshToken', 'alias' => 'RefreshToken'));

		$this->ComponentCollection = $collection;

	}

/**
 * Initializes OAuthComponent for use in the controller
 *
 * @param Controller $controller A reference to the instantiating controller object
 * @return void
 */
	public function initialize(Controller $controller) {
		$this->request = $controller->request;
		$this->response = $controller->response;
		$this->_methods = $controller->methods;

		if (Configure::read('debug') > 0) {
			Debugger::checkSecurityKeys();
		}
	}

/**
 * Main engine that checks valid access_token and stores the associated user for retrival
 *
 * @see AuthComponent::startup()
 *
 * @param type $controller
 * @return boolean
 */
	public function startup(Controller $controller) {

		foreach ($this->components as $component_name) {
			App::import('Component', $component_name);
			$component_class = "{$component_name}Component";
			$this->$component_name = new $component_class($this->ComponentCollection);
			$this->$component_name->startup($controller);
		}

		$methods = array_flip(array_map('strtolower', $controller->methods));
		$action = strtolower($controller->request->params['action']);

		$this->authenticate = Hash::merge($this->_authDefaults, $this->authenticate);
		$this->User = ClassRegistry::init(array(
			'class' => $this->authenticate['userModel'],
			'alias' => $this->authenticate['userModel']
			));

		$isMissingAction = (
			$controller->scaffold === false &&
			!isset($methods[$action])
		);
		if ($isMissingAction) {
			return true;
		}

		$allowedActions = $this->allowedActions;
		$denyedActions = $this->denyedActions;

		$isAllowed = (
		($this->allowedActions == array('*') ||
			in_array($action, array_map('strtolower', $allowedActions))) &&
			!in_array($action, array_map('strtolower', $denyedActions))
		);

		if ($isAllowed) {
			return true;
		}

		try {
			$this->isAuthorized();
			$this->user(null, $this->AccessToken->id);
		} catch (OAuth2AuthenticateException $e) {
			$e->sendHttpResponse();
			return false;
		}
		return true;
	}

/**
 * Checks if user is valid using OAuth2-php library
 *
 * @see OAuth2::getBearerToken()
 * @see OAuth2::verifyAccessToken()
 *
 * @return boolean true if carrying valid token, false if not
 */
	public function isAuthorized() {

            try {
                $this->AccessToken->id = $this->getBearerToken();
                $this->verifyAccessToken($this->AccessToken->id);
            } catch (Exception $e) {
                $error['error'] = $e->getMessage();
                if (method_exists($e, 'getDescription')) {
                    $error_msg = $e->getDescription();
                }

                $this->ApiCommon->errorNotification($error_msg);

                throw $e;
            }

		return true;
	}

/**
 * Takes a list of actions in the current controller for which authentication is not required, or
 * no parameters to allow all actions.
 *
 * You can use allow with either an array, or var args.
 *
 * `$this->OAuth->allow(array('edit', 'add'));` or
 * `$this->OAuth->allow('edit', 'add');` or
 * `$this->OAuth->allow();` to allow all actions.
 *
 * @param string|array $action,... Controller action name or array of actions
 * @return void
 */
	public function allow($action = null) {
		$args = func_get_args();
		if (empty($args) || $action === null) {
			$this->allowedActions = $this->_methods;
		} else {
			if (isset($args[0]) && is_array($args[0])) {
				$args = $args[0];
			}
			$this->allowedActions = array_merge($this->allowedActions, $args);
		}
	}

/**
 * Removes items from the list of allowed/no authentication required actions.
 *
 * You can use deny with either an array, or var args.
 *
 * `$this->OAuth->deny(array('edit', 'add'));` or
 * `$this->OAuth->deny('edit', 'add');` or
 * `$this->OAuth->deny();` to remove all items from the allowed list
 *
 * @param string|array $action,... Controller action name or array of actions
 * @return void
 * @see OAuthComponent::allow()
 */
	public function deny($action = null) {
		$args = func_get_args();
		if (empty($args) || $action === null) {
			$this->allowedActions = array();
		} else {
			if (isset($args[0]) && is_array($args[0])) {
				$args = $args[0];
			}
			foreach ($args as $arg) {
				$i = array_search($arg, $this->allowedActions);
				if (is_int($i)) {
					unset($this->allowedActions[$i]);
				}
			}
			$this->allowedActions = array_values($this->allowedActions);
		}
	}
/**
 * Gets the user associated to the current access token.
 *
 * Will return array of all user fields by default
 * You can specify specific fields like so:
 *
 * $id = $this->OAuth->user('id');
 *
 * @param type $field
 * @return mixed array of user fields if $field is blank, string value if $field is set and $fields is avaliable, false on failure
 */
	public function user($field = null, $token = null) {
		if (!$this->_user) {
			$this->AccessToken->bindModel(array(
				'belongsTo' => array(
				'User' => array(
					'className' => $this->authenticate['userModel'],
					'foreignKey' => 'user_id'
					)
				)
				));
			$token = empty($token) ? $this->getBearerToken() : $token;
			$data = $this->AccessToken->find('first', array(
				'conditions' => array('oauth_token' => $token),
				'recursive' => 1
			));
			if (!$data) {
				return false;
			}
			$this->_user = $data['User'];
		}
		if (empty($field)) {
			return $this->_user;
		} elseif (isset($this->_user[$field])) {
			return $this->_user[$field];
		}
		return false;
	}

/**
 * Convenience function for hashing client_secret (or whatever else)
 *
 * @param string $password
 * @return string Hashed password
 */
	public static function hash($password) {
		return Security::hash($password, null, true);
	}

/**
 * Convenience function to invalidate all a users tokens, for example when they change their password
 *
 * @param int $user_id
 * @param string $tokens 'both' (default) to remove both AccessTokens and RefreshTokens or remove just one type using 'access' or 'refresh'
 */
	public function invalidateUserTokens($user_id, $tokens = 'both') {
		if ($tokens == 'access' || $tokens == 'both') {
			$this->AccessToken->deleteAll(array('user_id' => $user_id), false);
		}
		if ($tokens == 'refresh' || $tokens == 'both') {
			$this->RefreshToken->deleteAll(array('user_id' => $user_id), false);
		}
	}

/**
 * Fakes the OAuth2.php vendor class extension for variables
 *
 * @param string $name
 * @return mixed
 */
	public function __get($name) {
		if (isset($this->OAuth2->{$name})) {
			try {
				return $this->OAuth2->{$name};
			} catch (Exception $e) {
				$e->sendHttpResponse();
			}
		}
	}

/**
 * Fakes the OAuth2.php vendor class extension for methods
 *
 * @param string $name
 * @param mixed $arguments
 * @return mixed
 * @throws Exception
 */
	public function __call($name, $arguments) {

		if (method_exists($this->OAuth2, $name)) {
			try {
				return call_user_func_array(array($this->OAuth2, $name), $arguments);
			} catch (Exception $e) {
				$error['error'] = $e->getMessage();
				if (method_exists($e, 'getDescription')) {
					$error_msg = $e->getDescription();
				}

				$this->ApiCommon->errorNotification($error_msg);

				throw $e;
			}
		}
	}

/**
 * Below are the library interface implementations
 *
 */

/**
 * Check client details are valid
 *
 * @see IOAuth2Storage::checkClientCredentials().
 *
 * @param string $client_id
 * @param string $client_secret
 * @return mixed array of client credentials if valid, false if not
 */
	public function checkClientCredentials($client_id, $client_secret = null) {
		$conditions = array('Client.client_id' => $client_id);
		if ($client_secret) {
			$conditions['Client.client_secret'] = $client_secret;
		}
		$client = $this->Client->find('first', array(
			'conditions' => $conditions,
			'recursive' => -1
		));

		if ($client) {
			return $client['Client'];
		};
		return false;
	}

/**
 * Get client details
 *
 * @see IOAuth2Storage::getClientDetails().
 *
 * @param string $client_id
 * @return boolean
 */
	public function getClientDetails($client_id) {
		$client = $this->Client->find('first', array(
			'conditions' => array('client_id' => $client_id),
			'fields' => array('client_id', 'redirect_uri'),
			'recursive' => -1
		));
		if ($client) {
			return $client['Client'];
		}
		return false;
	}

/**
 * Retrieve access token
 *
 * @see IOAuth2Storage::getAccessToken().
 *
 * @param string $oauth_token
 * @return mixed AccessToken array if valid, null if not
 */
	public function getAccessToken($oauth_token) {
		$accessToken = $this->AccessToken->find('first', array(
			'conditions' => array('oauth_token' => $oauth_token),
			'recursive' => -1,
		));
		if ($accessToken) {
			return $accessToken['AccessToken'];
		}
		return null;
	}

/**
 * Set access token
 *
 * @see IOAuth2Storage::setAccessToken().
 *
 * @param string $oauth_token
 * @param string $client_id
 * @param int $user_id
 * @param string $expires
 * @param string $scope
 * @return boolean true if successfull, false if failed
 */
	public function setAccessToken($oauth_token, $client_id, $user_id, $expires, $scope = null) {
		$data = array(
			'oauth_token' => $oauth_token,
			'client_id' => $client_id,
			'user_id' => $user_id,
			'expires' => $expires,
			'scope' => $scope
		);
		$this->AccessToken->create();
		return $this->AccessToken->save(array('AccessToken' => $data));
	}

/**
 * Partial implementation, just checks globally avaliable grant types
 *
 * @see IOAuth2Storage::checkRestrictedGrantType()
 *
 * @param string $client_id
 * @param string $grant_type
 * @return boolean If grant type is availiable to client
 */
	public function checkRestrictedGrantType($client_id, $grant_type) {
		return in_array($grant_type, $this->grantTypes);
	}

/**
 * Grant type: refresh_token
 *
 * @see IOAuth2RefreshTokens::getRefreshToken()
 *
 * @param string $refresh_token
 * @return mixed RefreshToken if valid, null if not
 */
	public function getRefreshToken($refresh_token) {
		$refreshToken = $this->RefreshToken->find('first', array(
			'conditions' => array('refresh_token' => $refresh_token),
			'recursive' => -1
		));
		if ($refreshToken) {
			return $refreshToken['RefreshToken'];
		}
		return null;
	}

/**
 * Grant type: refresh_token
 *
 * @see IOAuth2RefreshTokens::setRefreshToken()
 *
 * @param string $refresh_token
 * @param int $client_id
 * @param string $user_id
 * @param string $expires
 * @param string $scope
 * @return boolean true if successfull, false if fail
 */
	public function setRefreshToken($refresh_token, $client_id, $user_id, $expires, $scope = null) {
		$data = array(
			'refresh_token' => $refresh_token,
			'client_id' => $client_id,
			'user_id' => $user_id,
			'expires' => $expires,
			'scope' => $scope
		);
		$this->RefreshToken->create();
		return $this->RefreshToken->save(array('RefreshToken' => $data));
	}

/**
 * Grant type: refresh_token
 *
 * @see IOAuth2RefreshTokens::unsetRefreshToken()
 *
 * @param string $refresh_token
 * @return boolean true if successfull, false if not
 */
	public function unsetRefreshToken($refresh_token) {
		return $this->RefreshToken->delete($refresh_token);
	}

/**
 * Grant type: user_credentials
 *
 * @see IOAuth2GrantUser::checkUserCredentials()
 *
 * @param type $client_id
 * @param type $username
 * @param type $password
 */
	public function checkUserCredentials($client_id, $username, $password) {
		$user = $this->User->find('first', array(
			'conditions' => array(
				$this->authenticate['fields']['username'] => $username,
				$this->authenticate['fields']['password'] => AuthComponent::password($password)
			),
			'recursive' => -1
		));
		if ($user) {
			return array('user_id' => $user['User'][$this->User->primaryKey]);
		}
		return false;
	}

/**
 * Grant type: authorization_code
 *
 * @see IOAuth2GrantCode::getAuthCode()
 *
 * @param string $code
 * @return AuthCode if valid, null of not
 */
	public function getAuthCode($code) {
		$authCode = $this->AuthCode->find('first', array(
			'conditions' => array('code' => $code),
			'recursive' => -1
		));
		if ($authCode) {
			return $authCode['AuthCode'];
		}
		return null;
	}

/**
 * Grant type: authorization_code
 *
 * @see IOAuth2GrantCode::setAuthCode().
 *
 * @param string $code
 * @param string $client_id
 * @param int $user_id
 * @param string $redirect_uri
 * @param string $expires
 * @param string $scope
 * @return boolean true if successfull, otherwise false
 */
	public function setAuthCode($code, $client_id, $user_id, $redirect_uri, $expires, $scope = null) {
		$data = array(
			'code' => $code,
			'client_id' => $client_id,
			'user_id' => $user_id,
			'redirect_uri' => $redirect_uri,
			'expires' => $expires,
			'scope' => $scope
		);
		$this->AuthCode->create();
		return $this->AuthCode->save(array('AuthCode' => $data));
	}

	public function createAccessToken($client_id, $user_id, $scope = NULL){
		return $this->OAuth2->createAccessToken($client_id, $user_id, $scope);
	}

	public function refreshAccessToken(){

		$AccessToken = $this->AccessToken->find('first', array(
				'conditions' => array('oauth_token' => $this->getBearerToken()),
				'recursive' => 1,
		));

        if(!empty($AccessToken)){
            $this->AccessToken->delete($AccessToken['AccessToken']['oauth_token']);
            $token = $this->OAuth2->createAccessToken($AccessToken['Client']['client_id'], $AccessToken['Client']['user_id']);
            return $token;
        }
	}

	public function getBearerToken() {

		if(empty($this->request->data['Root']['access_token'])){
//		    return parent::getBearerToken();
		}
		else{
			return $this->request->data['Root']['access_token'];
		}
	}


    public function verifyAccessToken($token_param, $scope = NULL) {
        $tokenType = $this->getVariable(OAuth2::CONFIG_TOKEN_TYPE);
        $realm = $this->getVariable(OAuth2::CONFIG_WWW_REALM);


        if (!$token_param) { // Access token was not provided
            throw new OAuth2AuthenticateException(OAuth2::HTTP_BAD_REQUEST, $tokenType, $realm, OAuth2::ERROR_INVALID_REQUEST, 'The access token required.', $scope);
        }

        // Get the stored token data (from the implementing subclass)
        $token = $this->getAccessToken($token_param);
        if ($token === NULL) {
            throw new OAuth2AuthenticateException(OAuth2::HTTP_UNAUTHORIZED, $tokenType, $realm, OAuth2::ERROR_INVALID_GRANT, 'The access token provided is invalid.', $scope);
        }

        // Check we have a well formed token
        if (!isset($token["expires"]) || !isset($token["client_id"])) {
            throw new OAuth2AuthenticateException(OAuth2::HTTP_UNAUTHORIZED, $tokenType, $realm, OAuth2::ERROR_INVALID_GRANT, 'Malformed token (missing "expires" or "client_id")', $scope);
        }

        // Check token expiration (expires is a mandatory paramter)
        if (isset($token["expires"]) && time() > $token["expires"]) {
            throw new OAuth2AuthenticateException(OAuth2::HTTP_UNAUTHORIZED, $tokenType, $realm, OAuth2::ERROR_INVALID_GRANT, 'The access token provided has expired.', $scope);
        }

        // Check scope, if provided
        // If token doesn't have a scope, it's NULL/empty, or it's insufficient, then throw an error
        if ($scope && (!isset($token["scope"]) || !$token["scope"] || !$this->checkScope($scope, $token["scope"]))) {
            throw new OAuth2AuthenticateException(OAuth2::HTTP_FORBIDDEN, $tokenType, $realm, OAuth2::ERROR_INSUFFICIENT_SCOPE, 'The request requires higher privileges than provided by the access token.', $scope);
        }

        return $token;
    }
}
