<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Link extends Model {

	protected $fillable = ['name'];

	public function signature(){
		return $this->belongsTo('App\Signature');
	}

	public function setSignatureAttribute($signature){
		$this->signature_id = $signature->id;
	}

}
