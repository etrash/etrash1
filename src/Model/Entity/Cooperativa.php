<?php
namespace App\Model\Entity;

use Cake\Auth\DefaultPasswordHasher;
use Cake\ORM\Entity;

class Cooperativa extends Entity
{
	// Make all fields mass assignable for now.
	    protected $_accessible = ['*' => true];

	    // ...

	    protected function _setCooperativaSenha($password)
	    {
	        return (new DefaultPasswordHasher)->hash($password);
	    }
}

?>
