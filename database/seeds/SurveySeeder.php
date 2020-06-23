<?php

use App\Survey;
use Illuminate\Database\Seeder;

class SurveySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datas = [
            ['18062020/SID0', 'Yudi Andela', 'Jl. Nirmala 2 Blok N7 No.18, RT.006/RW.007, Cipondoh Makmur, Kec. Cipondoh, Kota Tangerang, Banten 15148, Indonesia', 'Banten 15148', 'Kota Tangerang', 'Kec. Cipondoh', '11005828905160001', '085262525593', 300, 500, -6.1778800, 106.6832200, 'On Progress', NULL],
            ['18062020/SID0', 'Yusza Mahardika', 'Jl. Sersan Halubali No.140, RT.004/RW.002, Jaka Mulya, Kec. Bekasi Sel., Kota Bks, Jawa Barat 17146, Indonesia', 'Jawa Barat 17146', 'Kota Bks', 'Kec. Bekasi Sel.', '11005828905160004', '08981189898', 300, 500, -6.2650200, 106.9584600],
            ['18062020/SID0', 'Henry Joey Steven Putinela', 'Bucend II, Samping SD Inpress, Ardipura, Jayapura Selatan', 'Ardipura', 'Samping SD Inpress', 'Bucend II', '9171021208810003', '0811177082', 300, 500, 0.0000000, 0.0000000],
            ['18062020/SID0', 'Deki Donald Tatuil', 'Jl. LIP Kuala Tembaga, Kuala Kencana, Kec. Kuala Kencana, Kabupaten Mimika, Papua 99910, Indonesia', 'Papua 99910', 'Kabupaten Mimika', 'Kec. Kuala Kencana', '9109012512720001', '08124005401', 300, 500, -4.4368500, 136.8770600],
            ['18062020/SID0', 'Reza Anhario', 'Dock 8 South Pacific Ocean, Jayapura City, Papua 99117, Indonesia', 'Papua 99117', 'Jayapura City', 'Dock 8 South Pacific Ocean', '3216061309960003', '081381133869', 300, 500, -2.5234900, 140.7292100, 'On Progress', NULL],
            ['18062020/SID0', 'Elisabet Tallo parura', 'Jl. Yos Sudarso No.3, Koperapoka, Kec. Mimika Baru, Kabupaten Mimika, Papua 99971, Indonesia', 'Papua 99971', 'Kabupaten Mimika', 'Kec. Mimika Baru', '732619520879000', '08125577880', 300, 500, -4.5502000, 136.8893700],
            ['18062020/SID0', 'TES', 'Sei Pinang, Mandau Talawang, Kapuas Regency, Central Kalimantan, Indonesia', 'Central Kalimantan', 'Kapuas Regency', 'Mandau Talawang', '12345678', '089877654321', 300, 500, -0.7892700, 113.9213300],
            ['18062020/SID0', 'Osman Nur', 'Jl. Kayu Batu Base G, Tj. Ria, Jayapura Utara, Kota Jayapura, Papua, Indonesia', 'Papua', 'Kota Jayapura', 'Jayapura Utara', '9171010604810001', '085344576181', 300, 500, -2.5236800, 140.7363700],
            ['18062020/SID0', 'Thifan Anjar', 'Jl. Kayu Batu Base G, Tj. Ria, Jayapura Utara, Kota Jayapura, Papua, Indonesia', 'Papua', 'Kota Jayapura', 'Jayapura Utara', '3275042909920010', '82218895708', 300, 500, -2.5237000, 140.7362900],
            ['18062020/SID0', 'JEFRRY J. F MASELA', 'kompleks LP kelas II A Abepura, Awiyo, Abepura, Kota Jayapura, Papua 99351, Indonesia', 'Papua 99351', 'Kota Jayapura', 'Abepura', '9171031505940001', '081289151431', 1000, 0, -2.6176200, 140.6729100],
            ['18062020/SID0', 'Ihwanudin', 'Jl. Ndorem Kai, Samkai, Kec. Merauke, Kabupaten Merauke, Papua 99614, Indonesia', 'Papua 99614', 'Kabupaten Merauke', 'Kec. Merauke', '9101110210940003', '085254074846', 300, 500, -8.5148200, 140.3891800],
            ['18062020/SID0', 'Irawan', 'Jl. Kayu Batu Base G, Tj. Ria, Jayapura Utara, Kota Jayapura, Papua, Indonesia', 'Papua', 'Kota Jayapura', 'Jayapura Utara', '9101012608950001', '082398569883', 300, 500, -2.5236200, 140.7361600],
            ['18062020/SID0', 'Muhammad Adhi Fitrasani', 'Jl. Bosnik BTN Kamkey No.48, Awiyo, Abepura, Kota Jayapura, Papua 99351, Indonesia', 'Papua 99351', 'Kota Jayapura', 'Abepura', '9103081309890002', '082199249776', 300, 500, -2.6171900, 140.6761000],
            ['18062020/SID0', 'Victor mario lamera', 'Unnamed Road, Wasur, Kec. Merauke, Merauke, Papua 99615, Indonesia', 'Papua 99615', 'Merauke', 'Kec. Merauke', '981010871997', '082198648897', 300, 500, -8.4956400, 140.4390800],
            ['18062020/SID0', 'Nurhani Irawan', 'Unnamed Road, Samkai, Kec. Merauke, Merauke, Papua 99614, Indonesia', 'Papua 99614', 'Merauke', 'Kec. Merauke', '9101055209990001', '081248567784', 300, 500, -8.5100200, 140.3840000],
            ['18062020/SID0', 'Junaedi', 'Jl. Ardipura No.3, Ardipura, Jayapura Sel., Kota Jayapura, Papua 99222, Indonesia', 'Papua 99222', 'Kota Jayapura', 'Jayapura Sel.', '9101012406940002', '082248226480', 300, 500, -2.5549000, 140.7033400],
            ['18062020/SID0', 'Vickly Mongkau', 'Jl. Garuda, Awiyo, Abepura, Kota Jayapura, Papua 99225, Indonesia', 'Papua 99225', 'Kota Jayapura', 'Abepura', '9171032307880002', '082198846318', 300, 500, -2.6115500, 140.6763800],
            ['18062020/SID0', 'Muhammad Didin adisasmita', 'Jl. Tanjung Ria II, RT.06 RW.02, Perum Air Bersih, Deplat Kanan, Base-G, Kelurahan Tanjung Ria, Distrik Jayapura Utara. Kota Jayapura, Provinsi Papua // kantor telkomsel dan Gedung Serba Guna Eden', 'Distrik Jayapura Utara. Kota Jayapura', 'Kelurahan Tanjung Ria', 'Base-G', '9171013007830001', '082297449659', 300, 500, -2.5151300, 140.7154500],
            ['18062020/SID0', 'Pablo Testing', 'Jl. Anggrek II No.7, RT.9/RW.2, Kuningan, Karet Kuningan, Kecamatan Setiabudi, Kota Jakarta Selatan, Daerah Khusus Ibukota Jakarta 12940, Indonesia', 'Daerah Khusus Ibukota Jakarta 12940', 'Kota Jakarta Selatan', 'Kecamatan Setiabudi', '325601829297', '08123456789', 1000, 0, -6.2170400, 106.8251400],
            ['18062020/SID0', 'Dzulharman Baruwadi', 'Jl. Rajawali No.34, Heledulaa Sel., Kota Tim., Kota Gorontalo, Gorontalo 96135, Indonesia', 'Gorontalo 96135', 'Kota Gorontalo', 'Kota Tim.', '7571050505950002', '081356790852', 300, 500, 0.5401200, 123.0659800],
            ['18062020/SID0', 'Edwin Telussa', 'Jl. Angkasa Pasir Dua Kel. Angkasa Pura Rt. 005/Rw.002, Angkasapura, Jayapura Utara, Kota Jayapura, Papua 99116, Indonesia', 'Papua 99116', 'Kota Jayapura', 'Jayapura Utara', '9171013007830001', '082198910635', 300, 500, -2.5096000, 140.7115500],
            ['18062020/SID0', 'Retno wulandari', 'Jl. Trikora No.80, Bayangkara, Jayapura Utara, Kota Jayapura, Papua 99114, Indonesia', 'Papua 99114', 'Kota Jayapura', 'Jayapura Utara', '91710130076830001', '081280122247', 500, 700, -2.5303100, 140.7162500],
            ['18062020/SID0', 'Kamasan YA.OB.S.S.Komboy', 'Jl. Lembah No.7, Angkasapura, Jayapura Utara, Kota Jayapura, Papua 99113, Indonesia', 'Papua 99113', 'Kota Jayapura', 'Jayapura Utara', '9171031804770005', '081394212345', 1000, 0, -2.5149500, 140.7119400],
            ['18062020/SID0', 'Elisabeth Tallo parura', 'Jln serayu gang Sahabat no 397 jalur 1  Kamoro Jaya, Kec. Mimika Baru, Kabupaten Mimika, Papua 99971, Indonesia', 'Papua 99971', 'Kabupaten Mimika', 'Kec. Mimika Baru', '7326195208790001', '08125577880', 300, 500, -4.5927300, 136.8699800],
            ['18062020/SID0', 'HERY SUGIANTO', 'Unnamed Road, Vim, Abepura, Kota Jayapura, Papua 99225, Indonesia', 'Papua 99225', 'Kota Jayapura', 'Abepura', '9171050708610002', '082199702100', 300, 500, -2.6016500, 140.6690600],
            ['18062020/SID0', 'SUBROTO', 'Jl. Raya Abepura No.99224, Wahno, Abepura, Kota Jayapura, Papua 99224, Indonesia', 'Papua 99224', 'Kota Jayapura', 'Abepura', '9171051104620002', '082199551326', 300, 500, -2.5962000, 140.6809500],
            ['18062020/SID0', 'ELSHAM PAPUA', 'Unnamed Road, Waena, Heram, Kota Jayapura, Papua 99225, Indonesia', 'Papua 99225', 'Kota Jayapura', 'Heram', '91710130076830001', '085244446586', 500, 700, -2.5957700, 140.6410000],
            ['18062020/SID0', 'Nur Annisa Ilham', 'Jl. K.H. Agussalim No.28, Balangnipa, Sinjai Utara, Kabupaten Sinjai, Sulawesi Selatan 92614, Indonesia', 'Sulawesi Selatan 92614', 'Kabupaten Sinjai', 'Sinjai Utara', '7307056608960001', '085255226789', 300, 500, -5.1205000, 120.2576900],
            ['18062020/SID0', 'INSOS LINCE MIRINO', 'Jl. Kayu Batu Base G, Tj. Ria, Jayapura Utara, Kota Jayapura, Papua, Indonesia', 'Papua', 'Kota Jayapura', 'Jayapura Utara', '9171036407950001', '082197697396', 300, 500, -2.5234600, 140.7361500],
        ];

        $num = 1;
        for ($i = 0; $i < count($datas); $i++) {
            Survey::create([
                'survey_id' => $datas[$i][0] . $num++,
                'name' => $datas[$i][1],
                'address' => $datas[$i][2],
                'province' => $datas[$i][3],
                'districts' => $datas[$i][4],
                'sub_district' => $datas[$i][5],
                'ktp' => (string) $datas[$i][6],
                'phone' => (string) $datas[$i][7],
                'price_from' => (int) $datas[$i][8],
                'price_to' => (int) $datas[$i][9],
                'latitude' => (float) $datas[$i][10],
                'longitude' => (float) $datas[$i][11]
            ]);
        }
    }
}
