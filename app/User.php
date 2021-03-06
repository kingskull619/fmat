<?php namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use App\Report;
use App\Log;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract {

	use SoftDeletes;

	use Authenticatable, CanResetPassword;

	protected $table = 'users';

	protected $fillable = ['name', 'email', 'user_name', 'first_name', 'last_name', 'password', 'type'];

	protected $hidden = ['password', 'remember_token'];

	public function comments(){
		return $this->hasMany('App\Comment');
	}

	public function favorites(){
		return $this->hasMany('App\Favorite');
	}

	public function logs(){
		return $this->hasMany('App\Log');
	}

	public function reports(){
		return $this->hasMany('App\Report');
	}

	public function setPasswordAttribute($value){
		if (!empty( ($value))){
			$this->attributes['password'] = bcrypt($value);
		}
	}

	public function getFullNameAttribute(){
		return $this->first_name . ' ' . $this->last_name;
	}

	public function ratings(){
		return $this->hasMany('App\Rating');
	}

	public function resources(){
		return $this->hasMany('App\Resource');
	}

	public function getPointsAttribute(){
		$rate = Log::where('user_id', '=', $this->id)
					->where('logueable_type', '=', 'App\Rating')
					->where('action', '=', 'create')
					->get();

		$resource = Log::where('user_id', '=', $this->id)
					->where('logueable_type', '=', 'App\Resource')
					->where('action', '=', 'create')
					->get();

		$comments = Log::where('user_id', '=', $this->id)
					->where('logueable_type', '=', 'App\Comment')
					->where('action', '=', 'create')
					->get();

		$ponts = (count($rate)*2) + (count($resource)*10 + count($comments)*1);

		return $ponts;

	}

	public function isLevel($level){
		switch ($level) {
			case 'user':
				return true;
			case 'admin':
				if ($this->type === 'admin') return true;
				if ($this->type === 'superadmin') return true;
				break;
			case 'superadmin':
				if ($this->type === 'superadmin') return true;
				break;
		}

		return false;
	}

	public function getReportsAdminAttribute(){
		if ( $this->isLevel('admin') ){
			return Report::where('admin_id', '=', $this->id)->get();
		}
	}

}
