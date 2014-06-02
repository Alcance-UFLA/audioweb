<?php
class Controller_Teste extends Controller_Geral {

    public function action_testar() {
        $this->definir_title('Teste Inicial');
        $this->adicionar_meta(array('name' => 'robots', 'content' => 'index,follow'));

        $view = View::Factory('teste/testar');
        $this->template->content = $view;
    }
}