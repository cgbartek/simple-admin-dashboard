<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Models\Domain;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function stats() : Response
    {
        $trash = 0;
        $active = 0;
        $internationalized = 0;
        $imprinted = 0;

        $domain = new Domain();
        $rows = $domain->select('deleted_at','is_idn','is_imprinted')->withTrashed()->get()->toArray();

        foreach($rows as $k => $row) {
          if($row['deleted_at']) {
            $trash++;
          } else {
            $active++;
          }
          if($row['is_idn']) {
            $internationalized++;
          }
          if($row['is_imprinted']) {
            $imprinted++;
          }
        }

        $stats = [
            // Active Domains
            'active' => $active,
            // Trashed Domains
            'trash' => $trash,
            // Internationalized Domains
            'internationalized' => $internationalized,
            // Imprinted Domains
            'imprinted' => $imprinted
        ];
        // Create HTTP response, 200 ok.
        $response = new Response($stats, Response::HTTP_OK);
        // Return HTTP response.
        return $response;
    }
}
