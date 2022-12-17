<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Models\Domain;

class DomainController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() : Response
    {
        // Search Filter

        $domains = Domain::all();
        // Create HTTP response, 200 ok.
        $response = new Response($domains, Response::HTTP_OK);
        // Return HTTP response.
        return $response;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) : Response
    {
        // Add Domains
        $output = [];
        if($request['lines'][0]) {
          foreach($request['lines'] as $v) {
            $domainData = array('domain_name' => $v);
            Domain::create($domainData);
            $output['result'] = 'Domains added.';
          }
        } else {
          $output['result'] = 'Error.';
        }

        $response = new Response($output, Response::HTTP_OK);

        return ($response);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) : Response
    {
        // Toggle Imprint
        $domain = new Domain();
        $rowId = $domain->where('id','=',$id);
        $row = $rowId->get()->toArray();
        $row = $row[0];
        if($row['is_imprinted']) {
          $rowId->update(array('is_imprinted' => false));
          $output['result'] = 'Set to false';
        } else {
          $rowId->update(array('is_imprinted' => true));
          $output['result'] = 'Set to true';
        }

        $response = new Response($output, Response::HTTP_OK);
        return $response;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id) : Response
    {
        // Delete Domains
        $domain = Domain::find($id);
        if($domain) {
          $destroy = Domain::destroy(2);
          $output['result'] = 'Domain deleted.';
        } else {
          $output['result'] = 'Delete error.';
        }

        $response = new Response($output, Response::HTTP_OK);
        return $response;
    }
}
