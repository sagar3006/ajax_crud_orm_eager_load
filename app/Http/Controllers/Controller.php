<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    // PREPARE ALL ERROR MESSAGES FOR VIEW
    function prepare_validation_errors($errors) {
    	$html = '<ul class="alert alert-danger" role="alert">';

        foreach($errors as $error)
            $html .= '<li style="margin-left: 15px;">' . $error . '</li>';

        $html .= '</ul>';

        return $html;
    }
}