<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Site_Template extends Controller_Site {

	public function action_generate_doc()
	{
            $user = Auth::instance()->get_user();
            if (!$user OR !($user->status == 'legal') OR !($user->requisites) OR !($user->requisites->confirmed))
            {
                $this->forward_404 ();
            }
            $filepath = Kohana::$config->load('file.upload_root').DIRECTORY_SEPARATOR.'documents';
            $docx = new docxGenerator( DOCROOT.'data'.DIRECTORY_SEPARATOR.'templates'.DIRECTORY_SEPARATOR.'partner_template.docx', $filepath. DIRECTORY_SEPARATOR.'temp');
            $filename = $filepath . DIRECTORY_SEPARATOR . $user->id.'.docx';
            $docx->val_all($user->requisites->requisites);
            $docx->save($filename);
            
            header('Content-Description: File Transfer');
            header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
            header('Content-Disposition: attachment; filename='.basename($filename));
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Pragma: public');
            header('Content-Length: '.filesize($filename));
            readfile($filename);
           // $this->redirect('site-')          
            exit();
	}
}

