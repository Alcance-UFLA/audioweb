<?php

class Controller_Home extends Controller {

	public function action_index()
	{
		$this->response->body('hello, world!');
	}

}
