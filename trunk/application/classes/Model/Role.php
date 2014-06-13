<?php
class Model_Role extends  Model_Auth_User  {

    protected $_table_name = 'autenticacao_roles';

    protected $_table_columns = array(
        'id' => NULL,
        'name' => NULL,
        'description' => NULL
	);

}
