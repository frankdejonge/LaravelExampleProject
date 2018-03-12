<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;

class EventsauceMessages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("CREATE TABLE eventsauce_messages (
    event_id UUID NOT NULL,
    event_type VARCHAR(255) NOT NULL,
    aggregate_root_id UUID NULL,
    time_of_recording TIMESTAMP(0) WITH TIME ZONE NOT NULL,
    payload JSON NOT NULL,
    PRIMARY KEY(event_id)
)");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('eventsauce_messages');
    }
}
