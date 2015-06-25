<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\Auth\DefaultPasswordHasher;

class Cooperativa extends Entity
{
	    protected function _setCooperativaSenha($password)
	    {
	        return (new DefaultPasswordHasher)->hash($password);
	    }
}

?>
