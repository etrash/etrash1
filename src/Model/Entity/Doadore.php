<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\Auth\DefaultPasswordHasher;

class Doadore extends Entity
{
	    protected function _setDoadorSenha($password)
	    {
	        return (new DefaultPasswordHasher)->hash($password);
	    }
}		

?>
