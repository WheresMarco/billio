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

    /**
     * Create organisation.
     *
     * @return void
     */
    public function create()
    {
        return 'not implemented';
    }

    /**
     * Update organisation.
     *
     * @return void
     */
    public function update( Request $request, int $id )
    {
        return 'not implemented';
    }

    /**
     * Delete organisation.
     *
     * @return void
     */
    public function delete( Request $request, int $id )
    {
        return 'not implemented';
    }
}
