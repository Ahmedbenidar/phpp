use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPhotoToProfesseursTable extends Migration
{
    public function up()
    {
        Schema::table('professeurs', function (Blueprint $table) {
            $table->string('photo')->nullable();
        });
    }

    public function down()
    {
        Schema::table('professeurs', function (Blueprint $table) {
            $table->dropColumn('photo');
        });
    }
}