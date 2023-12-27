<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    { 
        if (!Schema::hasTable('train'))
        {
        Schema::create('train', function (Blueprint $table) {
                $table->bigIncrements('train_id');   
                $table->string('train_book_advert',255)->nullable();   // หนังสืออ้างอิง
                $table->string('train_book_no',255)->nullable();       //เลขที่หนังสือ
                $table->date('train_date',255)->nullable();       // 
                $table->string('train_title',255)->nullable();       // เรื่อง
                $table->string('train_obj',255)->nullable();       // ัตถุประสงค์
                $table->string('train_locate',255)->nullable();       // สถานที่ไป
                $table->string('train_detail',255)->nullable();     //  รายละเอียด :
                $table->date('train_date_go',255)->nullable();  //วันที่ไป
                $table->date('train_date_back',255)->nullable();  //วันที่กลับ
                $table->string('train_vehicle',255)->nullable();       // ยานพาหนะที่ใช้ 
                $table->string('train_assign_work',255)->nullable();  //มอบหมายงายนให้
                $table->string('train_head',255)->nullable();  //หัวหน้า
                $table->string('train_expenses',255)->nullable();  //เบิกค่าใช้จ่าย
                $table->string('train_expenses_out',255)->nullable();  //เบิกค่าใช้จ่ายจากผู้จัด
                // $table->enum('train_expenses', ['Y', 'N', 'W'])->default('N');  //เบิกค่าใช้จ่าย
                $table->enum('train_active', ['REQ', 'AGREE', 'APPROVE', 'CANCEL', 'CONFIRM_CANCEL'])->default('REQ');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('train');
    }
};
