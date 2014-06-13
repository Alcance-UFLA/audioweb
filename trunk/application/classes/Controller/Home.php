<?php

class Controller_Home extends Controller_Geral {

	public function action_index()
	{
		$this->response->body('hello, world!');
	}

}
