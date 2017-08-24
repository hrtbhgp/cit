<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class EntregaPecas extends CI_Controller {

	public function GetFinalidades()
	{
		if ($this->session->logged_in !== true) {
			echo json_encode(array ('status'=> 403 ));
			return;
		}
		
		$this->load->helper('http');

		$sessionId = $this->session->session_id;
		$cookie =  $this->session->cookie;

		$nPag = 20;
		$cookie = 'CitiusNPag=NPag=' . $nPag . '; ' . 
			 	   	'ASP.NET_SessionId=' . $sessionId . '; ' .
					$cookie;
		$url = 'https://citius.tribunaisnet.mj.pt/habilus/myhabilus/pecproconline/Definicao.aspx';

		$resp = HttpRequest($url, $cookie);

		$tableAux =  explode('<select name="UcStepsPlaceholder1$UcStepFinalidade1$ddlFinalidade"', $resp['body'], 2)[1];
		$table = explode('</select>', $tableAux, 2)[0];
		$table = '<select ' . $table . "</select>";

		echo json_encode(array ('status'=> 200, 'response'=> $table));
		return;
	}
}
