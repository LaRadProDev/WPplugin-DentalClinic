<?php

namespace PassThisTest\Support;

use PassThisTest\Schemas\SchemaStats;
use PassThisTest\Schemas\SchemaFactory;
use PassThisTest\Schemas\SchemaQuizHistory;
use PassThisTest\Support\StatsSchedule;

class PluginActivator 
{

    public static function activate() 
    {
        $schema_factory = SchemaFactory::get_instance();
        $schema_factory->register(SchemaStats::class, 'ptt_stats');
        $schema_factory->register(SchemaQuizHistory::class, 'ptt_quiz_history');
        $schema_factory->setup_schemas();

        new StatsSchedule();
	}
}