<?php defined('SYSPATH') OR die('No direct script access.'); ?>

2014-05-29 22:49:27 --- EMERGENCY: ErrorException [ 4 ]: syntax error, unexpected 'endforeach' (T_ENDFOREACH) ~ APPPATH/views/template_geral.php [ 9 ] in file:line
2014-05-29 22:49:27 --- DEBUG: #0 [internal function]: Kohana_Core::shutdown_handler()
#1 {main} in file:line
2014-05-29 22:52:09 --- EMERGENCY: Kohana_Exception [ 0 ]: View variable is not set: links ~ SYSPATH/classes/Kohana/View.php [ 171 ] in /home/rubens/projetos/pessoal/kohana/application/classes/Controller/Geral.php:44
2014-05-29 22:52:09 --- DEBUG: #0 /home/rubens/projetos/pessoal/kohana/application/classes/Controller/Geral.php(44): Kohana_View->__get('links')
#1 /home/rubens/projetos/pessoal/kohana/application/classes/Controller/Geral.php(41): Controller_Geral->adicionar_link(Array)
#2 /home/rubens/projetos/pessoal/kohana/application/classes/Controller/Geral.php(15): Controller_Geral->adicionar_style(Array)
#3 /home/rubens/projetos/pessoal/kohana/system/classes/Kohana/Controller.php(69): Controller_Geral->before()
#4 [internal function]: Kohana_Controller->execute()
#5 /home/rubens/projetos/pessoal/kohana/system/classes/Kohana/Request/Client/Internal.php(97): ReflectionMethod->invoke(Object(Controller_Teste))
#6 /home/rubens/projetos/pessoal/kohana/system/classes/Kohana/Request/Client.php(114): Kohana_Request_Client_Internal->execute_request(Object(Request), Object(Response))
#7 /home/rubens/projetos/pessoal/kohana/system/classes/Kohana/Request.php(986): Kohana_Request_Client->execute(Object(Request))
#8 /home/rubens/projetos/pessoal/kohana/htdocs/index.php(118): Kohana_Request->execute()
#9 {main} in /home/rubens/projetos/pessoal/kohana/application/classes/Controller/Geral.php:44
2014-05-29 22:54:17 --- EMERGENCY: ErrorException [ 2 ]: strpos() expects parameter 1 to be string, array given ~ SYSPATH/classes/Kohana/HTML.php [ 242 ] in file:line
2014-05-29 22:54:17 --- DEBUG: #0 [internal function]: Kohana_Core::error_handler(2, 'strpos() expect...', '/home/rubens/pr...', 242, Array)
#1 /home/rubens/projetos/pessoal/kohana/system/classes/Kohana/HTML.php(242): strpos(Array, '://')
#2 /home/rubens/projetos/pessoal/kohana/application/views/template_geral.php(20): Kohana_HTML::script(Array)
#3 /home/rubens/projetos/pessoal/kohana/system/classes/Kohana/View.php(61): include('/home/rubens/pr...')
#4 /home/rubens/projetos/pessoal/kohana/system/classes/Kohana/View.php(348): Kohana_View::capture('/home/rubens/pr...', Array)
#5 /home/rubens/projetos/pessoal/kohana/system/classes/Kohana/Controller/Template.php(44): Kohana_View->render()
#6 /home/rubens/projetos/pessoal/kohana/application/classes/Controller/Geral.php(29): Kohana_Controller_Template->after()
#7 /home/rubens/projetos/pessoal/kohana/system/classes/Kohana/Controller.php(87): Controller_Geral->after()
#8 [internal function]: Kohana_Controller->execute()
#9 /home/rubens/projetos/pessoal/kohana/system/classes/Kohana/Request/Client/Internal.php(97): ReflectionMethod->invoke(Object(Controller_Teste))
#10 /home/rubens/projetos/pessoal/kohana/system/classes/Kohana/Request/Client.php(114): Kohana_Request_Client_Internal->execute_request(Object(Request), Object(Response))
#11 /home/rubens/projetos/pessoal/kohana/system/classes/Kohana/Request.php(986): Kohana_Request_Client->execute(Object(Request))
#12 /home/rubens/projetos/pessoal/kohana/htdocs/index.php(118): Kohana_Request->execute()
#13 {main} in file:line
2014-05-29 23:02:56 --- EMERGENCY: Kohana_Exception [ 0 ]: View variable is not set: links ~ SYSPATH/classes/Kohana/View.php [ 171 ] in /home/rubens/projetos/pessoal/kohana/application/classes/Controller/Geral.php:47
2014-05-29 23:02:56 --- DEBUG: #0 /home/rubens/projetos/pessoal/kohana/application/classes/Controller/Geral.php(47): Kohana_View->__get('links')
#1 /home/rubens/projetos/pessoal/kohana/application/classes/Controller/Geral.php(16): Controller_Geral->adicionar_style(Array)
#2 /home/rubens/projetos/pessoal/kohana/system/classes/Kohana/Controller.php(69): Controller_Geral->before()
#3 [internal function]: Kohana_Controller->execute()
#4 /home/rubens/projetos/pessoal/kohana/system/classes/Kohana/Request/Client/Internal.php(97): ReflectionMethod->invoke(Object(Controller_Teste))
#5 /home/rubens/projetos/pessoal/kohana/system/classes/Kohana/Request/Client.php(114): Kohana_Request_Client_Internal->execute_request(Object(Request), Object(Response))
#6 /home/rubens/projetos/pessoal/kohana/system/classes/Kohana/Request.php(986): Kohana_Request_Client->execute(Object(Request))
#7 /home/rubens/projetos/pessoal/kohana/htdocs/index.php(118): Kohana_Request->execute()
#8 {main} in /home/rubens/projetos/pessoal/kohana/application/classes/Controller/Geral.php:47
2014-05-29 23:43:51 --- EMERGENCY: ErrorException [ 1 ]: Using $this when not in object context ~ APPPATH/views/teste/testar.php [ 2 ] in file:line
2014-05-29 23:43:51 --- DEBUG: #0 [internal function]: Kohana_Core::shutdown_handler()
#1 {main} in file:line
2014-05-29 23:45:00 --- EMERGENCY: ErrorException [ 8 ]: Undefined variable: this ~ APPPATH/views/teste/testar.php [ 4 ] in /home/rubens/projetos/pessoal/kohana/application/views/teste/testar.php:4
2014-05-29 23:45:00 --- DEBUG: #0 /home/rubens/projetos/pessoal/kohana/application/views/teste/testar.php(4): Kohana_Core::error_handler(8, 'Undefined varia...', '/home/rubens/pr...', 4, Array)
#1 /home/rubens/projetos/pessoal/kohana/system/classes/Kohana/View.php(61): include('/home/rubens/pr...')
#2 /home/rubens/projetos/pessoal/kohana/system/classes/Kohana/View.php(348): Kohana_View::capture('/home/rubens/pr...', Array)
#3 /home/rubens/projetos/pessoal/kohana/system/classes/Kohana/View.php(228): Kohana_View->render()
#4 /home/rubens/projetos/pessoal/kohana/application/views/template_geral.php(17): Kohana_View->__toString()
#5 /home/rubens/projetos/pessoal/kohana/system/classes/Kohana/View.php(61): include('/home/rubens/pr...')
#6 /home/rubens/projetos/pessoal/kohana/system/classes/Kohana/View.php(348): Kohana_View::capture('/home/rubens/pr...', Array)
#7 /home/rubens/projetos/pessoal/kohana/system/classes/Kohana/Controller/Template.php(44): Kohana_View->render()
#8 /home/rubens/projetos/pessoal/kohana/application/classes/Controller/Geral.php(33): Kohana_Controller_Template->after()
#9 /home/rubens/projetos/pessoal/kohana/system/classes/Kohana/Controller.php(87): Controller_Geral->after()
#10 [internal function]: Kohana_Controller->execute()
#11 /home/rubens/projetos/pessoal/kohana/system/classes/Kohana/Request/Client/Internal.php(97): ReflectionMethod->invoke(Object(Controller_Teste))
#12 /home/rubens/projetos/pessoal/kohana/system/classes/Kohana/Request/Client.php(114): Kohana_Request_Client_Internal->execute_request(Object(Request), Object(Response))
#13 /home/rubens/projetos/pessoal/kohana/system/classes/Kohana/Request.php(986): Kohana_Request_Client->execute(Object(Request))
#14 /home/rubens/projetos/pessoal/kohana/htdocs/index.php(118): Kohana_Request->execute()
#15 {main} in /home/rubens/projetos/pessoal/kohana/application/views/teste/testar.php:4
2014-05-29 23:49:34 --- EMERGENCY: ErrorException [ 8 ]: Undefined variable: template ~ APPPATH/views/teste/testar.php [ 4 ] in /home/rubens/projetos/pessoal/kohana/application/views/teste/testar.php:4
2014-05-29 23:49:34 --- DEBUG: #0 /home/rubens/projetos/pessoal/kohana/application/views/teste/testar.php(4): Kohana_Core::error_handler(8, 'Undefined varia...', '/home/rubens/pr...', 4, Array)
#1 /home/rubens/projetos/pessoal/kohana/system/classes/Kohana/View.php(61): include('/home/rubens/pr...')
#2 /home/rubens/projetos/pessoal/kohana/system/classes/Kohana/View.php(348): Kohana_View::capture('/home/rubens/pr...', Array)
#3 /home/rubens/projetos/pessoal/kohana/system/classes/Kohana/View.php(228): Kohana_View->render()
#4 /home/rubens/projetos/pessoal/kohana/application/views/template_geral.php(17): Kohana_View->__toString()
#5 /home/rubens/projetos/pessoal/kohana/system/classes/Kohana/View.php(61): include('/home/rubens/pr...')
#6 /home/rubens/projetos/pessoal/kohana/system/classes/Kohana/View.php(348): Kohana_View::capture('/home/rubens/pr...', Array)
#7 /home/rubens/projetos/pessoal/kohana/system/classes/Kohana/Controller/Template.php(44): Kohana_View->render()
#8 /home/rubens/projetos/pessoal/kohana/application/classes/Controller/Geral.php(33): Kohana_Controller_Template->after()
#9 /home/rubens/projetos/pessoal/kohana/system/classes/Kohana/Controller.php(87): Controller_Geral->after()
#10 [internal function]: Kohana_Controller->execute()
#11 /home/rubens/projetos/pessoal/kohana/system/classes/Kohana/Request/Client/Internal.php(97): ReflectionMethod->invoke(Object(Controller_Teste))
#12 /home/rubens/projetos/pessoal/kohana/system/classes/Kohana/Request/Client.php(114): Kohana_Request_Client_Internal->execute_request(Object(Request), Object(Response))
#13 /home/rubens/projetos/pessoal/kohana/system/classes/Kohana/Request.php(986): Kohana_Request_Client->execute(Object(Request))
#14 /home/rubens/projetos/pessoal/kohana/htdocs/index.php(118): Kohana_Request->execute()
#15 {main} in /home/rubens/projetos/pessoal/kohana/application/views/teste/testar.php:4