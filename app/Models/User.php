<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Facades\DB;
use Cviebrock\EloquentSluggable\Sluggable;

use App\Models\Currency;
use App\Models\CreditsTransfersLog;
use App\Models\Announcement;

//class User extends Authenticatable
class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, HasRoles;
    use Sluggable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    //protected $guard_name = 'api';
    protected $guard_name = 'web';

    //protected $fillable = [ 'name', 'email'.'username', 'password','prenom','region_id','city_id','postal_code','gender','num_civique','street','age_group','mobile_phone','num_tel','godfather' ];
    protected $guarded = [];

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
    */
    public function sluggable()
    {
        return [
            'slug' => [
                 'source'             => ['username'],
                 'separator'          => '-',
                 'unique'             => true,
                 'onUpdate'           => false,
                 'includeTrashed'     => false,
            ]
        ];
    }
    /* public function getRouteKeyName()
    {
        return 'slug';
    } */
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function creditsTransfersLogs()
    {
        return $this->hasMany(CreditsTransfersLog::class,'sent_by','id');
    }

    /**
     * 
     * Setting up the relationship between user and region. Each user has a region
     */
    public function region()
    {
        return $this->belongsTo(\App\Models\Region::class);
    }

    /**
     * 
     * Setting up the relationship between user and city. Each user has a city
     */
    public function city()
    {
        return $this->belongsTo(\App\Models\City::class);
    }
    /**
     * 
     * Setting up the relationship between users and currency. A many to many relationship
     */
    public function currencies()
    {
        return $this->belongsToMany(Currency::class)->withPivot('free_currency','paid_currency')->withTimestamps();
    }
    /**
     * 
     * Setting up the relationship between users and currency. A many to many relationship
     */
    public function agerange()
    {
        return $this->belongsTo(\App\Models\AgeRange::class,'age_group','id');
    }
    /**
     * 
     * the relation betwin a user and the one that created the account
     */
    public function thegodfather()
    {
        return $this->belongsTo(User::class, 'godfather','id');
    }

    /**
     * 
     * the relation betwin a user and all the accounts he created
     */
    public function godchildren()
    {
        return $this->hasMany(User::class, 'godfather', 'id');
    }

    public function allGodchildren()
    {
        return $this->allGodchildren()->with('allGodchildren');
    }

    public function announcementsPosted()
    {
        return $this->hasMany(Announcement::class, 'posted_by', 'id');
    }

    public function announcementsValidated()
    {
        return $this->hasMany(Announcement::class, 'validated_by', 'id');
    }

    public function scopeMyAnnouncements($query)
    {
        if($this->hasAnyRole(['chef-vendeur','vendeur'])){
            return Announcement::where('posted_by',$this->id)->where('publication_status','<',4)->orWhere('owner',$this->id);
        } elseif ($this->hasAnyRole(['super-admin','admin'])) {
            return Announcement::where('posted_by',$this->id)->where('publication_status','<',4)->orWhere('owner',$this->id);
        }

        return $announcements = Announcement::where('owner',$this->id);
    }

    public function scopeMyEvents($query)
    {
        if($this->hasAnyRole(['chef-vendeur','vendeur'])){
            return \App\Models\Event::where('posted_by',$this->id)->orWhere('owner',$this->id);
        } elseif ($this->hasAnyRole(['super-admin','admin'])) {
            return \App\Models\Event::where('posted_by',$this->id)->orWhere('owner',$this->id);
        }

        return $announcements = \App\Models\Event::where('owner',$this->id);
    }
    
    /**
     * 
     * Get users with role Banquier
     */
    public function scopeBankers($query)
    {
        return $query->whereHas("roles", function($q){ $q->where("name", "Banquier"); } );
    }
    
    /**
     * 
     * Get users with role admin or super-admin
     */
    public function scopeAdmins($query)
    {
        return $query->whereHas("roles", function($q){ $q->where("name", "super-admin")->orWhere('name','admin'); } );
    }
 
    /**
     * 
     * Get users with role chef vendor or vendor
     */
    public function scopeVendors($query)
    {
        return $query->whereHas("roles", function($q){ $q->where('name','chef-vendeur')->orWhere('name','vendeur'); } );
    }
    /**
     * 
     * Get users with role vendor or higher
     */
    public function scopeVendorsHigher($query)
    {
        return $query->whereHas("roles", function($q){ $q->where("name", "admin")
                                                         ->orWhere('name','super-admin')
                                                         ->orWhere('name','Banquier')
                                                         ->orWhere('name','chef vendeur')
                                                         ->orWhere('name','vendeur'); } );
    }
        
    /**
     * 
     * Each role has a different list of users it can send currency to 
     */
    public function scopeRecipientList($query)
    {
        if($this->hasAnyRole(['admin','super-admin'])){
            $users = User::where('id','!=',$this->id)
                            ->where('profile_status','<=',1);
        } elseif($this->hasAnyRole(['chef-vendeur','vendeur'])){
            $users = $this->godchildren();
        } elseif($this->hasAnyRole(['banquier','banker'])){
            $users = $query->whereHas("roles", function($q){
                                         $q->where('name','super-admin')
                                           ->orWhere('name','admin')
                                           ->orWhere('name','banquier');
                                        })
                        ->where('id','!=',$this->id)
                        ->where('profile_status','<',2) ;
        }
        else{
            $users = $query->whereHas("roles", function($q){
                                         $q->where('name','!=','super-admin')
                                           ->where('name','!=','admin')
                                           ->Where('name','!=','chef-vendeur')
                                           ->Where('name','!=','vendeur')
                                           ->Where('name','!=','banquier'); 
                                        })
                        ->where('id','!=',$this->id)
                        ->where('profile_status','<',2) ;
        }

        return $users;
    }
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Format created date value to custom
     *
     * @param $value
     * @return string
     */
    public function getCreatedAtAttribute($value)
    {
        $created_at = Carbon::make($value);
        return Carbon::createFromFormat('Y-m-d H:i:s', $created_at)->diffForHumans();
        /* return Carbon::createFromFormat('Y-m-d H:i:s', $created_at)->format('d-m-Y à H:i:s');
        return $created_at->toDateString().' à '.$created_at->toTimeString(); */
    }

    /**
     * Format updated date value to custom
     *
     * @param $value
     * @return string
     */
    public function getUpdatedAtAttribute($value)
    {
        $updated_at = Carbon::make($value);
        return $updated_at->toDateString().' à '.$updated_at->toTimeString();
    }

    /**
     * return the data of a given currency for a given user
     */
    public function getUserCurrency($currency_id)
    {
        return $this->currencies()
                    ->wherePivot('currency_id',$currency_id)
                    ->first();
    }

    /**
     * set the data of a given currency for a given user
     */
    public function setUserCurrency($currency_id, $pivot_field = [])
    {
        $currency = $this->getUserCurrency($currency_id);
        //dd($currency->pivot->free_currency);
        if($currency == null)
        {//User has no ammount of picked currency
            $this->currencies()->attach([$currency_id => $pivot_field]);
        } else {//we just update the values
            $pivot_field = ['free_currency' => null,'paid_currency' => null];
            $pivot_field['free_currency'] += @$currency->pivot->free_currency;
            $pivot_field['paid_currency'] += @$currency->pivot->paid_currency;
            $this->currencies()->updateExistingPivot($currency_id,$pivot_field);
        }

        return $this->getUserCurrency($currency_id);
    }
    /**
     * This methode is used to update the wallet of a user on publication of an announcement or event
     * 
     * $currency the currency
     * $publication_column the publication column will tell if we are saving an annoucenement or an event
     */
    public function updateUserWallet($currency = 1, $publication_column="annoucements_price")
    {
        if($publication_column == "annoucements_price"){
            $pivot_column = "paid_currency";
        } else {
            $pivot_column = "free_currency";
            $publication_column = "events_price";
        }
        //Get amount to pauy from user's role
        $price_to_pay = $this->roles->first()->$publication_column ;
        //Get user's currencey data
        $user_currencies = $this->setUserCurrency($currency);
        //update currency value and save
        $user_currencies->pivot->$pivot_column -= $price_to_pay;
        return $user_currencies->pivot->save();
    }
    /**
     * 
     * assign a role to a user through
     */
    public function giveRole(\App\Models\Role $role)
    {
        if($role === null)
        {return false;}
        //We add a restriction for the banker and super-admin profiles  
        if(strtolower($role->name) === 'banquier' || strtolower($role->name) === 'super-admin'|| strtolower($role->name) === 'admin'|| strtolower($role->name) === 'chef vendeur'){
            return false;
        }
        if($this->hasRole('super-admin')){//We prevent to change the super-admin role
            return false;
        }

        if($this->assignRole($role->name)){
            $free_credit_amount = intval($role->free_credit);
            $paid_credit_amount = intval($role->paid_credit);
            $pivot_fields       = [
                                    'free_currency' => $free_credit_amount,
                                    'paid_currency' => $paid_credit_amount
                                  ];
            $this->setUserCurrency($role->currency_id , $pivot_fields);

            return true;
        }
        return false;
    }
    /**
     * get the main role of a user excluding some roles
     */
    public function mainRole()
    {
        return $this->roles->wherenotin('name',['chef-vendeur','banquier','membre'])->first();
    }
    
    public function userHasEnoughCredit(String $contenu_price, String $type = 'free_currency')
    {
        //First get the user role excluding some roles
        $role = $this->roles->wherenotin('name',['chef-vendeur','banquier','membre'])->first();
        //Get the amount to spend from the role
        $amount_to_spend = intval($role->$contenu_price);
        //Make sure currency id is set
        if(!$role->currency_id)
            return false;
        //Make sure user has enough of the needed currency 
        // dd($amount_to_spend,intval($this->setUserCurrency($role->currency_id)->pivot->$type));
        if($amount_to_spend <= intval($this->setUserCurrency($role->currency_id)->pivot->$type)){
            return true ;
        }

        return false ;
    }
    /**
     * Each annoucement is linked to an event
     * When saving a new annoucement we need to list the events that are not linked to any announcement
     * This methods will help do that through a join between the announcements and events
     */
    public function getUnlinkedEvents()
    {
        return DB::table("events")
                    ->leftjoin('announcements', 'events.id', '=', 'announcements.event_id')
                    ->where(function($query){
                        $query->where('events.owner',1)
                                ->orWhere('events.posted_by',@$this->id);
                    })
                    ->where('announcements.event_id',NULL) ;

        /* return DB::table('events')
                    ->leftjoin('announcements', 'events.id', '=', 'announcements.event_id')
                    ->where('events.owner',@$this->id)
                    ->orWhere('events.posted_by',@$this->id)
                    ->where('announcements.event_id',NULL) ; */
                    /* ->select('events.title','events.id','announcements.event_id','events.owner') ->pluck('events.title','events.id') ;*/
    }

    public function getRoleFromCurrency($currency_id)
    {
        return $this->currencies->where('id',$currency_id)->first()->roles->first();
    }
    /**
     * Will return the list of prices based on user's role
     */
    public function getPricesList($role_id)
    {
        $role = $this->roles->where('id',$role_id)->first();
        //dd($role->currency->name);
        $role_prices = $role->credit_prices;
        $list = [];
        foreach ($role_prices as $key => $item) {
            $list[$item->price] = $item->credit_amount;
        }
        return $list ;
        dd($list);
    }
    /**
     * Build a select list with prices for a given role
     */
    public function buildPricesOptions($role_id)
    {
        $role = $this->roles->where('id',$role_id)->first();
        $list = $this->getPricesList($role_id);
        $select_options = '';
        foreach ($list as $price => $amount) {
            $select_options .= '<option value="'.$price.'" data-amount="'.$amount.'">'.$amount.' '.$role->currency->name.' à $'.$price.'.00</option>';
        }
        // dd($select_options);
        return $select_options;
    }
}
