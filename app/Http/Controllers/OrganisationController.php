<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Organisation;

class OrganisationController extends Controller
{
    /**
     * Get all organisations.
     *
     * @return void
     */
    public function organisations()
    {
        $organisations = Organisation::all();

        return $organisations;
    }
}
