<?php

namespace PassThisTest\Support;

use PassThisTest\Models\Stats;

class StatsSchedule {
    public function __construct()
    {
        if (! wp_next_scheduled ( 'daily_stats_event' )) {
            wp_schedule_event(time(), 'daily', 'daily_stats_event');
        }
        add_action('daily_stats_event', [$this, 'daily_stats_event_callback']);
    }

    public function daily_stats_event_callback()
    {
        
    }
}