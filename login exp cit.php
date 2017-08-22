<html>
 <head>
  <title>PHP Test</title>
 </head>
 <body>
 <?php
    $url = 'https://citius.tribunaisnet.mj.pt/habilus/myhabilus/login.aspx?ReturnUrl=/habilus/myhabilus/Entrada.aspx';
    $sessionId = generateRandomString($length = 24);

    $postData = array(
        'txtUserName' => 'pedroaguedamoreira-11650p@adv.oa.pt',
        'txtUserPass' => 'benzin',
        '__VIEWSTATE' => '/wEPDwUIOTE4NjE1ODcPZBYCAgMPZBYGAggPZBYCAgEPZBYEAgMPDxYCHgRUZXh0BbABQSBwYWxhdnJhLXBhc3NlIGRldmVyw6EgY29udGVyIHBlbG8gbWVub3MgNiBjYXJhY3RlcmVzIG51bSBtw6F4aW1vIGRlIDIwLCBkZXZlbmRvIHNlciBjb21wb3N0YSBwb3IgcGVsbyBtZW5vcyAxIGxldHJhKHMpIG1pbsO6c2N1bGEocyksIDEgbGV0cmEocykgbWFpw7pzY3VsYShzKSBlIDEgbsO6bWVybyhzKS5kZAIFDw8WBB4MRXJyb3JNZXNzYWdlBbABQSBwYWxhdnJhLXBhc3NlIGRldmVyw6EgY29udGVyIHBlbG8gbWVub3MgNiBjYXJhY3RlcmVzIG51bSBtw6F4aW1vIGRlIDIwLCBkZXZlbmRvIHNlciBjb21wb3N0YSBwb3IgcGVsbyBtZW5vcyAxIGxldHJhKHMpIG1pbsO6c2N1bGEocyksIDEgbGV0cmEocykgbWFpw7pzY3VsYShzKSBlIDEgbsO6bWVybyhzKS4eB0Rpc3BsYXkLKipTeXN0ZW0uV2ViLlVJLldlYkNvbnRyb2xzLlZhbGlkYXRvckRpc3BsYXkAZGQCCw8WAh4HVmlzaWJsZWhkAhMPDxYCHwAFTHYuIDUuMC43LjAtMSB8IMOabHRpbWEgYWN0dWFsaXphw6fDo286IDE0LzA3LzIwMTcgMTI6MTk6NDI8YnIgLz7CqSAyMDA0LTIwMTdkZBgCBR5fX0NvbnRyb2xzUmVxdWlyZVBvc3RCYWNrS2V5X18WAQUKSW1CdG5Mb2dpbgUPQ2FwdGNoYUNvbnRyb2wxDwUkYzA1ZmIyZTAtNTRlNi00OTU3LTkyMDAtOWY1M2MzNzIxOThlZASzlfpov4UCjjsKKGnu2ydGsJGm',
        '__EVENTVALIDATION' => '/wEdAARh7wnWickpjBo3q+mE3aEdY3plgk0YBAefRz3MyBlTcA6Puailico2fWp193TJgzFPnrZHYVKWMZcDKd6/3ifWaPbS/L+NdEL67Kqx8oN37iZdYmM=',
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

    if($response === FALSE){
        die(curl_error($ch));
    }

    echo $httpcode;
    echo $body;
    echo $header;
    
    $headers = get_headers_from_curl_response($header);
    echo "<p></p>";
    print_r($headers);

    function get_headers_from_curl_response($header_text)
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

    function generateRandomString($length = 24) {
        $characters = '0123456789aaaaaaaaaabbbbbbbbbbccccccccccddddddddddeeeeeeeeeeffffffffffgggggggggghhhhhhhhhhiiiiiiiiiijjjjjjjjjjkkkkkkkkkkllllllllllmmmmmmmmmmnnnnnnnnnnooooooooooppppppppppqqqqqqqqqqrrrrrrrrrrssssssssssttttttttttuuuuuuuuuvvvvvvvvvvwwwwwwwwwwxxxxxxxxxxyyyyyyyyyyzzzzzzzzzz';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
 ?>
 </body>
</html>

