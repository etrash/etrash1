<?php
namespace App\Model\Entity;

use Cake\Auth\DefaultPasswordHasher;
use Cake\ORM\Entity;

class Doador extends Entity
{
	// Make all fields mass assignable for now.
	    protected $_accessible = ['*' => true];

	    // ...

	    protected function _setDoadorSenha($password)
	    {
	        return (new DefaultPasswordHasher)->hash($password);
	    }
}

?>
