<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Identity extends CI_Controller {

	public function login()
	{
		$username = $this->input->post('username');
		$password = $this->input->post('password');

		$url = 'https://citius.tribunaisnet.mj.pt/habilus/myhabilus/login.aspx?ReturnUrl=/habilus/myhabilus/Entrada.aspx';
		$sessionId = $this->generateRandomString($length = 24);
		$startUp = $this->getStartUpValues();

		$postData = array(
			'txtUserName' => $username, 
			'txtUserPass' => $password, 
			'__VIEWSTATE' => $startUp["viewState"],
			'__EVENTVALIDATION' => $startUp["eventValidation"],
			'ImBtnLogin.x' => '24',
			'ImBtnLogin.y' => '29'
		);

		$ch = curl_init($url);
		curl_setopt_array(
			$ch, 
			array(
				CURLOPT_POST => true,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_COOKIE => 'ASP.NET_SessionId=' . $sessionId .'',
				CURLOPT_HTTPHEADER => 
					array(
						'Content-type: application/x-www-form-urlencoded',
						'User-Agent: Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.36'
					),
				CURLOPT_POSTFIELDS => http_build_query($postData),
				CURLOPT_SSL_VERIFYPEER => false,
				CURLOPT_SSL_VERIFYHOST => false,
				CURLOPT_HEADER => true,
				CURLOPT_VERBOSE => true
		));

		$response = curl_exec($ch);
		$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
		$header = substr($response, 0, $header_size);
		$body = substr($response, $header_size);
		$headers = $this->get_headers_from_curl_response($header);

		if($response === FALSE){
			echo json_encode(array ('status'=> 500 ));
			return;
		}
		
		if ($httpcode == 302) { // Success

			$this->session->set_userdata(
				array(
					'username'  => $username,
					'email'     => $password,
					'logged_in' => TRUE,
					'session_id'=> $sessionId,
					'cookie' 	=> explode(";", $headers["Set-Cookie"], 2)[0] . ';'
				)
			);
			
			echo json_encode(array ('status'=> 200 ));
		}
		else { // Failed login
			echo json_encode(array ('status'=> 400 ));
		}
	}

	public function logout()
	{
		session_destroy();
	}

	private function get_headers_from_curl_response($header_text)
    {
        $headers = array();

        foreach (explode("\n", $header_text) as $i => $line)
        {
            if (strpos($line, ':') !== false)
            {
                list ($key, $value) = explode(': ', $line);

                $headers[$key] = $value;
            }
        }

        return $headers;
    }

    private function generateRandomString($length = 24) {
        $characters = '0123456789aaaaaaaaaabbbbbbbbbbccccccccccddddddddddeeeeeeeeeeffffffffffgggggggggghhhhhhhhhhiiiiiiiiiijjjjjjjjjjkkkkkkkkkkllllllllllmmmmmmmmmmnnnnnnnnnnooooooooooppppppppppqqqqqqqqqqrrrrrrrrrrssssssssssttttttttttuuuuuuuuuvvvvvvvvvvwwwwwwwwwwxxxxxxxxxxyyyyyyyyyyzzzzzzzzzz';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
	}
	
	private function getStartUpValues(){
		$this->load->helper('http');
		$this->load->helper('string');

		$resp = HttpRequest('https://citius.tribunaisnet.mj.pt/habilus/myhabilus/login.aspx?ReturnUrl=%2fhabilus%2fmyhabilus%2fEntrada.aspx', '');

		$viewState = getValueInsideString($resp['body'], 'id="__VIEWSTATE" value="', '"');
		$eventValidation = getValueInsideString($resp['body'], 'id="__EVENTVALIDATION" value="', '"');
		
		return array('viewState' => $viewState, 'eventValidation' => $eventValidation);
	}
}
