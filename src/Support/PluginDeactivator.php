<?php

namespace PassThisTest\Support;

use PassThisTest\Schemas\SchemaStats;
use PassThisTest\Schemas\SchemaQuizHistory;

class PluginDeactivator 
{
	public static function deactivate() {
		(new SchemaStats('ptt_stats'))->delete();
		(new SchemaQuizHistory('ptt_quiz_history'))->delete();

		wp_clear_scheduled_hook('daily_stats_event');
	}
}
