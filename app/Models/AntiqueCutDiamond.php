<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
  

class AntiqueCutDiamond extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'antique_cut_diamonds';


    // Relationship to wishlists
    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    public function orderItems()
    {
        return $this->morphMany(OrderItem::class, 'diamond');
    }
 
     // Function to get cut description dynamically
     public function getCutDescriptionAttribute()
     {
         $descriptions = [
             'GOOD' => 'Quality cut with good proportions to return most light that enters.',
             'VERY GOOD' => 'High-quality cut with good proportions that return almost all light that enters.',
             'EXCELLENT' => 'High-quality cut with near-perfect proportions that return nearly all light that enters.',
             'IDEAL' => 'Perfectly-proportioned to return all light that enters for maximum fire. Only 5% of mined diamonds meet this standard.',
         ];
 
         return $descriptions[$this->cut] ?? 'Description not available for this cut.';
     }
 
     // Function to get color description dynamically
     public function getColorDescriptionAttribute()
     {
         $descriptions = [
             'M' => 'Have a definite yellow tint that visible to the naked eye. Like K and L diamonds, M color diamonds offer fantastic value for money.',
             'L' => 'Color is most noticeable when viewed from the side, have a slightly yellow tone',
             'K' => 'Color noticeable with the naked eye. there are several color grades that are lower than K.',
             'J' => 'Color noticeable when seen side-by-side with diamonds of better grades. Good value.',
             'I' => 'Slight color noticeable when seen side-by-side with diamonds of better grades. Great value.',
             'H' => 'Nearly colorless. Slight color may be noticeable when seen side-by-side with diamonds of better grades. Excellent value.',
             'G' => 'Nearly colorless. Gemologists will be able to detect some color, but appears colorless to non-experts. Excellent value.',
             'F' => 'Almost colorless, with slight color visible to expert gemologists. Still considered a very high quality grade.',
             'E' => 'Almost completely colorless. So close to perfectly colorless, only expert gemologists may be able to detect any color.',
             'D' => 'Completely colorless, displaying the most desirable icy white brilliance. Very rare in nature and the most expensive color.',
         ];
 
         return $descriptions[$this->color] ?? 'Description not available for this color.';
     }
 
     // Function to get clarity description dynamically
     public function getClarityDescriptionAttribute()
     {
         $descriptions = [
             'I2' => 'Flawless, the highest clarity grade, with no visible inclusions or blemishes.',
             'I1' => 'Included. Inclusions are very easy to see under 10x magnification and may be seen with the naked eye.',
             'SI2' => 'Slightly included with more inclusions than SI1. Easily seen by an expert under 10x magnification but difficult to see with the naked eye.',
             'SI1' => 'Slightly included. Easily seen by an expert under 10x magnification but difficult to see with the naked eye',
             'SI3' => 'Flawless, the highest clarity grade, with no visible inclusions or blemishes.',
             'VS1' => 'Very slightly included. Easier for an expert to see inclusions under 10x magnification, and generally not visible to the naked eye.',
             'VS2' => 'Very slightly included. Easier for an expert to see inclusions under 10x magnification, and generally not visible to the naked eye; slightly more inclusions than VS1.',
             'VVS1' => 'Very, very slightly included. Extremely small inclusions are difficult for an expert to see under 10x magnification and invisible to the naked eye',
             'VVS2' => 'Very, very slightly included. Extremely small inclusions are difficult for an expert to see under 10x magnification and invisible to the naked eye; slightly more inclusions than VVS1.',
             'IF' => 'Internally flawless. The highest clarity grade, with no flaws or inclusions. Very rare and expensive.',
             'FL' => 'Flawless. The highest clarity grade, with no visible inclusions or blemishes.',
         ];
 
         return $descriptions[$this->clarity] ?? 'Description not available for this clarity.';
     }
}
