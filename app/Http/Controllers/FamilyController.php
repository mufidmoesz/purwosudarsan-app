<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FamilyController extends Controller
{
    //
    public function getFamilyData()
    {
        $people = DB::table('people')->get();

    $familyData = $people->map(function ($person) {
    // Build data array with all possible keys
        $data = [
            'id'     => $person->id,
            'pids'   => $this->getPartnerIds($person->id),
            'mid'    => $person->mother_id,
            'fid'    => $person->father_id,
            'gender' => $person->gender,
            'photo'  => $this->resolvePhoto($person->photo_url),
            'img'    => $this->resolvePhoto($person->photo_url),
            'name'   => $person->name,
            'born'   => $person->birth_date,
            'email'  => $person->email,
            'phone'  => $person->phone,
            'city'   => $person->city,
            'country'=> $person->country,
        ];

        // Remove empty pids
        if (empty($data['pids'])) {
            unset($data['pids']);
        }

        // Filter out all null values
        $data = array_filter($data, function ($value) {
            return !is_null($value);
        });

        return $data;
    });

        return response()->json($familyData);
    }

    private function getPartnerIds($personId)
    {
        $asPerson = DB::table('spouses')
            ->where('person_id', $personId)
            ->pluck('spouse_id');

        $asPartner = DB::table('spouses')
            ->where('spouse_id', $personId)
            ->pluck('person_id');

        return $asPerson
            ->merge($asPartner)
            ->unique()
            ->values()
            ->toArray();
    }

    private function resolvePhoto(?string $photo): ?string
    {
        if (!$photo) {
            return null;
        }

        if (filter_var($photo, FILTER_VALIDATE_URL)) {
            return $photo;
        }

        return asset('storage/' . ltrim($photo, '/'));
    }
}
