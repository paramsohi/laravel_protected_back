<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    protected $table = 'site_settings_new';

    protected $fillable = ['order_email','master_password','vat','basic_price','ownership_change_price',
    'next_day_del_price','standard_del_price','reg_price','late_fee','contact_email','gold_price','cert_price',
      'reorder_cert_price','breeder_transfer_price','date_time_format'];
}
