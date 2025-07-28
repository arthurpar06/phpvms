<?php

namespace App\Models;

use App\Contracts\Model;
use App\Dto\SimBriefOfp\SimBriefOfp;
use App\Dto\SimBriefOfp\SimBriefOfpNavlog;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

/**
 * @property string     $id                   The Simbrief OFP ID
 * @property int        $user_id              The user that generated this
 * @property string     $flight_id            Optional, if attached to a flight, removed if attached to PIREP
 * @property string     $pirep_id             Optional, if attached to a PIREP, removed if attached to flight
 * @property string     $aircraft_id          The aircraft this is for
 * @property string     $ofp_json_path
 * @property string     $fare_data            JSON string of the fare data that was generated
 * @property Collection $images
 * @property Collection $files
 * @property Flight     $flight
 * @property User       $user
 * @property array      $xml
 * @property Aircraft   $aircraft
 * @property string     $acars_flightplan_url
 */
class SimBrief extends Model
{
    use HasFactory;

    public $table = 'simbrief';

    public $incrementing = false;

    protected $fillable = [
        'id',
        'user_id',
        'flight_id',
        'aircraft_id',
        'pirep_id',
        'ofp_json_path',
        'fare_data',
        'created_at',
        'updated_at',
    ];

    protected function ofp(): Attribute
    {
        return Attribute::make(get: function () {
            if (empty($this->attributes['ofp_json_path'])) {
                return [];
            }

            $ofp = Storage::json($this->attributes['ofp_json_path']);

            // dd($ofp);

            // dd(SimBriefOfpNavlog::from($ofp['alternate_navlog'][0]));

            return dd(SimBriefOfp::from(Storage::get($this->attributes['ofp_json_path'])));
        });
    }

    /**
     * Returns a list of images
     */
    protected function images(): Attribute
    {
        return Attribute::make(get: function () {
            $images = collect();
            $base_url = $this->ofp->images->directory;
            foreach ($this->ofp->images->map as $image) {
                $images->push([
                    'name' => $image->name->__toString(),
                    'url'  => $base_url.$image->link,
                ]);
            }

            return $images;
        });
    }

    /**
     * Return all of the flight plans
     */
    protected function files(): Attribute
    {
        return Attribute::make(get: function () {
            $flightplans = collect();
            $base_url = $this->ofp->fms_downloads->directory;

            foreach ($this->ofp->fms_downloads->children() as $child) {
                if ($child->getName() === 'directory') {
                    continue;
                }

                $flightplans->push([
                    'name' => $child->name->__toString(),
                    'url'  => $base_url.$child->link,
                ]);
            }

            return $flightplans;
        });
    }

    /*
     * Relationships
     */
    public function aircraft(): BelongsTo
    {
        return $this->belongsTo(Aircraft::class, 'aircraft_id');
    }

    public function flight(): BelongsTo
    {
        return $this->belongsTo(Flight::class, 'flight_id');
    }

    public function pirep(): BelongsTo
    {
        return $this->belongsTo(Pirep::class, 'pirep_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    protected function casts(): array
    {
        return [
            'user_id' => 'integer',
        ];
    }
}
