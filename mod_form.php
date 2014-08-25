<?php

defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot . '/course/moodleform_mod.php');
require_once($CFG->libdir . '/coursecatlib.php');

/**
 * Inscricao settings form
 */
class mod_inscricao_mod_form extends moodleform_mod {

    /**
     * Form fields definition
     */
    public function definition() {
        global $CFG, $DB, $COURSE;
        $id = $COURSE->id;
        $mform = $this->_form;


        //Informaçoes comuns a todos os processos
        $mform->addElement('header', 'general', get_string('general', 'form'));

 		$mform->addElement('date_selector', 'inicio', 'Início das inscrições'); 
      
 		$mform->addElement('date_selector', 'fim', 'Término das inscrições'); 

 		$mform->addElement('text', 'email', 'Email do processo'); 
        $mform->setType('email', PARAM_TEXT );

        $mform->addElement('text', 'fone', 'Telefone do processo'); 
        $mform->setType('fone', PARAM_TEXT );

        $mform->addElement('text', 'coordenadoria', 'Coordenadoria'); 
        $mform->setType('coordenadoria', PARAM_TEXT );



 		// busca a categoria do processo(curso)
        $processo = $DB->get_record('course', array('id' => $id), '*', MUST_EXIST);
        $categoria = $processo->category;

        // renderiza de acordo com a categoria
        switch ($categoria) {
        	case '2': // Capacitação
        		// não possui informações adcionais	
        		break;
        	case '3': // Especialização
        		$mform->addElement('header', 'especializacoes', 'Especializações');
        		// busca todas as especializações no banco de dados
        		$sql = "SELECT id, nome_especializacao FROM mdl_especializacao";
        		$especializacoes = $DB->get_records_sql($sql);
        		foreach ($especializacoes as $value) {
            		$mform->addElement('advcheckbox',  $value->nome_especializacao.'_id',  null, $value->nome_especializacao, array('group' => 1));
        		}
        		$this->add_checkbox_controller(1);
        		break;
        	case '4': // Professor Formador
        		
        		break;
        	case '5': // Tutor
        		
        		break;
        	default:
        		
        		break;
        }

/**********************************************************************************************************************
        //BUSCA TODOS OS CURSOS NO BANCO DE DADOS
        // se o tipo de inscrição for 'com cursos', selecionar os cursos
        $mform->addElement('header', 'cursos', 'Disciplinas');
        $sql = "SELECT id, nome_curso FROM proc_cursos";
        $cursos = $DB->get_records_sql($sql);
        //ADICIONA CURSOS COMO CHECKBOX
        foreach ($cursos as $value) {
            $mform->addElement('advcheckbox',  $value->nome_curso.'_id',  null, $value->nome_curso, array('group' => 1));
            // condional de exibicao dos cursos
            $mform->disabledIf($value->nome_curso.'_id', 'tipo_inscricao', 'neq', 2);
        }
        $this->add_checkbox_controller(1);

        $mform->addElement('html', '<br><br>');


        //BUSCA TODOS AS ESPECIALIZAÇÕES NO BANCO
        $mform->addElement('header', 'cursos', 'Especialização(Cursos)');
        $sql = "SELECT id, curso_nome FROM especializacao";
        $especializacoes = $DB->get_records_sql($sql);
        foreach ($especializacoes as $value) {
            $mform->addElement('advcheckbox',  $value->curso_nome.'_id',  null, $value->curso_nome, array('group' => 2));
             $mform->disabledIf($value->curso_nome.'_id', 'tipo_inscricao', 'neq', 3);
        }
        $this->add_checkbox_controller(2);



        //BUSCA TODOS OS POLOS NO BANCO
        $mform->addElement('header', 'polos', 'Polos');
        $sql = 'SELECT id, nome_polo FROM polos';
        $polos = $DB->get_records_sql($sql);

        foreach ($polos as $value) {
            $mform->addElement('advcheckbox',  $value->nome_polo.'_id',  null, $value->nome_polo, array('group' => 3));
        }
        $this->add_checkbox_controller(3);
*/
        // Common module settings ----------------------------------------------
        $this->standard_coursemodule_elements();

        // Common action buttons
        $this->add_action_buttons();
    }
}

