<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class GalleryController extends Controller
{
    public function index()
    {
        $galleryItems = [
            [
                'id' => 1,
                'title' => 'Championship Trophy 2026',
                'category' => 'TOURNAMENTS',
                'desc' => 'United Seniors Vellanad lifting the tournament championship cup with gold medals and fireworks.',
                'tag' => 'Finals',
                'date' => '2026'
            ],
            [
                'id' => 2,
                'title' => 'Opening Ceremony & Team Parade',
                'category' => 'CELEBRATIONS',
                'desc' => 'Grand opening event with USV club flags, tournament torch, and team squad presentation.',
                'tag' => 'Ceremony',
                'date' => '2026'
            ],
            [
                'id' => 3,
                'title' => 'Super Over Last Ball Thriller',
                'category' => 'MATCHES',
                'desc' => 'High tension moment during the thrilling finish of the USV Premier League qualifier match.',
                'tag' => 'Match Moment',
                'date' => '2026'
            ],
            [
                'id' => 4,
                'title' => 'Best Batsman & Orange Cap Ceremony',
                'category' => 'AWARDS',
                'desc' => 'Honoring top run scorer of the season with golden willow and milestone certificate.',
                'tag' => 'Awards',
                'date' => '2026'
            ],
            [
                'id' => 5,
                'title' => 'Squad Morning Practice Session',
                'category' => 'TRAINING',
                'desc' => 'Pre-season conditioning and intensive fielding drills at Vellanad Sports Ground.',
                'tag' => 'Training',
                'date' => '2026'
            ],
            [
                'id' => 6,
                'title' => 'Club Annual Meet & Celebrations',
                'category' => 'CELEBRATIONS',
                'desc' => 'Annual gathering of all USV senior members, supporters, and executive committee.',
                'tag' => 'Club Meet',
                'date' => '2026'
            ],
            [
                'id' => 7,
                'title' => 'Player of the Match Honors',
                'category' => 'AWARDS',
                'desc' => 'Match winner all-round performance felicitation in the post-match presentation area.',
                'tag' => 'Awards',
                'date' => '2026'
            ],
            [
                'id' => 8,
                'title' => 'Electrifying Stadium Crowd',
                'category' => 'MATCHES',
                'desc' => 'Overwhelming local support cheering for United Seniors Vellanad during the finals.',
                'tag' => 'Fans & Crowd',
                'date' => '2026'
            ]
        ];

        $categories = ['ALL', 'TOURNAMENTS', 'MATCHES', 'CELEBRATIONS', 'AWARDS', 'TRAINING'];

        return view('gallery.index', compact('galleryItems', 'categories'));
    }
}
