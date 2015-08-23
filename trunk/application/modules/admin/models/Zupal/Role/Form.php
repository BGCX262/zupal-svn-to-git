<?

class Zupal_Role_Form
extends Zupal_Form_Abstract
{

	public function __construct($pRole = NULL)
	{

		$ini_path = dirname(__FILE__) . DS . 'Form.ini';
		$config = new Zend_Config_Ini($ini_path, 'fields');

		parent::__construct($config);

		$root = Zend_Controller_Front::getInstance()->getBaseUrl() . DS . 'admin' . DS . 'acl' . DS;

		if (is_null($pRole)):
			$pRole = new Zupal_Roles();
		elseif (is_string($pRole)):
			$pRole = new Zupal_Roles($pRole);
		endif;

		$this->set_domain($pRole);

		if ($pRole->identity())
		{
			$this->setAction($root . 'roleupdatevalidate');
		}
		else
		{
			$this->setAction($root  . 'roleaddvalidate');
			$this->submit->setLabel('Create Role');
		}

		$this->load_parents();

		$this->setMethod('post');
	}

/* @@@@@@@@@@@@@@@@@@@@@@@@@@@@@ load_parents @@@@@@@@@@@@@@@@@@@@@@@@@@@@@ */
	/**
	*
	* @return <type>
	*/
	public function load_parents ()
	{
		$stub = Zupal_Roles::getInstance();
		$parents = $stub->find(array(), 'id');

		foreach ($parents as $parent):
			$this->parent->addMultiOption($parent->identity(), $parent->label);
		endforeach;
	}

/* @@@@@@@@@@@@@@@@@@@@@@@@@@@@@ domain_fields @@@@@@@@@@@@@@@@@@@@@@@@@@@@@ */
	/**
	*
	*/
	public function domain_fields ()
	{
		return array(
			'id', 'label', 'notes'
		);
	}

}