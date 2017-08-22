<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notificacoes extends CI_Controller {

	public function GetNotificationsPage()
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
		$url = 'https://citius.tribunaisnet.mj.pt/habilus/myhabilus/NotificacoesCitacoes/NotCitIndex.aspx?Lidas=1';

		$resp = HttpRequest($url, $cookie);

		$tableAux =  explode('<div id="divNotificacoes"', $resp['body'], 2)[1];
		$table = explode('</table>', $tableAux, 2)[0];
		$table = '<div id="divNotificacoes" ' . $table . "</table></div></div>";

		echo json_encode(array ('status'=> 200, 'response'=> $table));
		return;
	}
}
