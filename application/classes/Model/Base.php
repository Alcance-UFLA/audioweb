<?php
/**
 * Model base para os outros models de ORM
 * @author Rubens Takiguti Ribeiro <rubs33@gmail.com>
 */
abstract class Model_Base extends ORM {

	/**
	 * Apaga o registro e as entidades filhas em cascata
	 * @return void
	 */
	public function delete_cascade()
	{
		if ( ! $this->loaded()) {
			throw new LogicException("Não é possível apagar o registro.");
		}
		foreach ($this->has_many() as $nome => $dados) {
			foreach ($this->get($nome)->find_all() as $filho) {
				if ($filho instanceof Model_Base) {
					$filho->delete_cascade();
				} elseif ($filho instanceof ORM) {
					$filho->delete();
				}
			}
		}
		return $this->delete();
	}
}