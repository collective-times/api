<?php

use Illuminate\Database\Seeder;

class SitesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sites = config('crawl_sites');
        foreach ($sites as $site) {
            DB::table('sites')->insert([
                'title' => $site['title'],
                'feed_url' => $site['crawl_url'],
                'source_url' => $site['source_url'],
                'crawlable' => $site['enabled'],
                'class' => $site['title'],
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ]);
        }
    }
}
