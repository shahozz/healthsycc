
    
    <?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::create('vital_signs', function (Blueprint $table) {
            $table->id();

            
            $table->foreignId('user_id')
                  ->constrained()
                  ->onDelete('cascade');

            
            $table->enum('type', ['blood_pressure', 'blood_sugar', 'heart_rate', 'oxygen']);

           
            $table->decimal('value', 8, 2)->nullable();

            
            $table->integer('systolic')->nullable();
            $table->integer('diastolic')->nullable();

            
            $table->enum('status', ['normal', 'elevated', 'critical']);

            $table->timestamp('measured_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vital_signs');
    }
};


