<?php

namespace Database\Seeders;

use App\Models\Config;
use Illuminate\Database\Seeder;
use Modules\Admin\Entities\Admin;
use Modules\Admin\Entities\Brand;
use Modules\Admin\Entities\BrandOwner;
use Modules\Admin\Entities\BrandSlider;
use Modules\Admin\Entities\Location;
use Modules\Brand\Entities\BrandEmployee;
use Modules\Brand\Entities\Service;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Admin::create([
           'name'=>'admin',
           'email'=>'admin@admin.com',
           'password'=>'secret',
        ]);
        Config::create([
            'ratio'=>1
        ]);
        $owner_1=BrandOwner::create([
            'name'=>'brand owner-1 name',
            'email'=>'owner1@brand.vaya',
            'phone'=>'+966512345622',
        ]);
        $owner_2=BrandOwner::create([
            'name'=>'brand owner-2 name',
            'email'=>'owner2@brand.vaya',
            'phone'=>'+966512345623',
        ]);
        $location_1=Location::create([
            'title_ar'=>'موقع 1',
            'title_en'=>'location 1',
            'polygon'=>'POLYGON((41.90178440267445 21.505668450550385,40.98442600423695 21.735469230764796,40.67131565267445 20.957798361030807,41.15471409017445 20.711367927139012,41.90178440267445 21.505668450550385))'
        ]);
        $location_2=Location::create([
            'title_ar'=>'موقع 2',
            'title_en'=>'location 2',
            'polygon'=>'POLYGON((40.06157444173695 21.658909579094395,39.51225803548695 21.551657805853864,39.57268284017445 21.31133106416874,39.91875217611195 21.162847620083987,40.25932834798695 21.526109961761282,40.06157444173695 21.658909579094395))'
        ]);
        $brand_1=Brand::create([
           'brand_owner_id'=>$owner_1->id,
           'location_id'=>$location_1->id,
            'title_ar'=>'براند ١',
            'title_en'=>'brand 1',
            'description_ar'=>'براند ١....',
            'description_en'=>'brand 1....',
            'commercial_name'=>'commercial_name',
            'commercial_num'=>'commercial_num',
            'start_contract'=>now(),
            'mobile'=>'05'.rand(11111111,99999999),
            'phone'=>'05'.rand(11111111,99999999),
        ]);
        BrandEmployee::create([
            'brand_id'=>$brand_1->id,
            'type'=>'officer',
            'name'=>'officer',
            'email'=>'officer@brand.vaya',
            'phone'=>'05'.rand(11111111,99999999),
        ]);
        $brand_1_technical=BrandEmployee::create([
            'brand_id'=>$brand_1->id,
            'type'=>'technical',
            'name'=>'technical',
            'email'=>'technical@brand.vaya',
            'phone'=>'05'.rand(11111111,99999999),
        ]);
        $brand_1_service_1=Service::create([
           'brand_id'=>$brand_1->id,
            'name'=>'service 1 of '.$brand_1->title_en,
            'description'=>'service desc',
            'price'=>100,
            'shifts'=>[
                rand(1,12)." AM",
                rand(1,12)." AM",
                rand(1,12)." PM",
                rand(1,12)." PM"
            ]
        ]);
        $brand_1_service_1->technicals()->sync($brand_1_technical->id);

        $brand_1_service_2=Service::create([
            'brand_id'=>$brand_1->id,
            'name'=>'service 2 of '.$brand_1->title_en,
            'description'=>'service desc',
            'price'=>100,
            'shifts'=>[
                rand(1,12)." AM",
                rand(1,12)." AM",
                rand(1,12)." PM",
                rand(1,12)." PM"
            ]
        ]);
        $brand_1_service_2->technicals()->sync($brand_1_technical->id);

        $brand_2=Brand::create([
           'brand_owner_id'=>$owner_2->id,
           'location_id'=>$location_2->id,
            'title_ar'=>'براند 2',
            'title_en'=>'brand 2',
            'description_ar'=>'براند 2....',
            'description_en'=>'brand 2....',
            'commercial_name'=>'commercial_name',
            'commercial_num'=>'commercial_num',
            'start_contract'=>now(),
            'mobile'=>'05'.rand(11111111,99999999),
            'phone'=>'05'.rand(11111111,99999999),
        ]);
        BrandEmployee::create([
            'brand_id'=>$brand_2->id,
            'type'=>'officer',
            'name'=>'officer',
            'email'=>'officer@brand2.vaya',
            'phone'=>'05'.rand(11111111,99999999),
        ]);
        $brand_2_technical=BrandEmployee::create([
            'brand_id'=>$brand_2->id,
            'type'=>'technical',
            'name'=>'technical',
            'email'=>'technical2@brand.vaya',
            'phone'=>'05'.rand(11111111,99999999),
        ]);
        $brand_2_service_1=Service::create([
            'brand_id'=>$brand_2->id,
            'name'=>'service 1 of '.$brand_2->title_en,
            'description'=>'service desc',
            'price'=>100,
            'shifts'=>[
                rand(1,12)." AM",
                rand(1,12)." AM",
                rand(1,12)." PM",
                rand(1,12)." PM"
            ]
        ]);
        $brand_2_service_1->technicals()->sync($brand_2_technical->id);
        BrandSlider::create([
            'title_ar'=>'الشريحة الاولي',
            'title_en'=>'slid 1',
            'description_ar'=>'نص ...',
            'description_en'=>'notes ...'
        ]);
    }
}
