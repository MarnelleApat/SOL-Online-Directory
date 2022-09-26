<?php

namespace App\WPRestApi;


class WP_ResponseParser
{

    private $data;

    public function __construct( $data )
    {
        $this->data = $data;
    }

    public function process()
    {
        if($this->getResponseStatusCode($this->data) == "404")
        {
            return "Error 404. Record not found.";
        }
        else
        {
            $response = file_get_contents( $this->data, false );

            return json_decode( $response );
        }
    }

    protected function getResponseStatusCode( $url )
    {
        $get_header = get_headers($url);
        $status = substr($get_header[0], 9, 3);
        return $status;

    }

}
