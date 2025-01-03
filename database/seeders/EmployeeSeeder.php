<?php

namespace Database\Seeders;

use App\Models\Division;
use App\Models\Employee;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jsonData = '[
            {"id": 4827,"image": "https://i.pravatar.cc/100?1","name": "Nama Pegawai Satu","phone": "123-456-7890","division": {"id": 9283,"name": "Mobile Apps"},"position": "Senior Developer"},
            {"id": 1945,"image": "https://i.pravatar.cc/100?2","name": "Nama Pegawai Dua","phone": "987-654-3210","division": {"id": 7654,"name": "QA"},"position": "Project Manager"},
            {"id": 8732,"image": "https://i.pravatar.cc/100?3","name": "Nama Pegawai Tiga","phone": "456-789-1230","division": {"id": 3421,"name": "Full Stack"},"position": "Full Stack Engineer"},
            {"id": 5678,"image": "https://i.pravatar.cc/100?4","name": "Nama Pegawai Empat","phone": "654-321-9870","division": {"id": 8765,"name": "Backend"},"position": "Backend Developer"},
            {"id": 2345,"image": "https://i.pravatar.cc/100?5","name": "Nama Pegawai Lima","phone": "321-654-9870","division": {"id": 2109,"name": "Frontend"},"position": "Frontend Developer"},
            {"id": 6789,"image": "https://i.pravatar.cc/100?6","name": "Nama Pegawai Enam","phone": "789-123-4560","division": {"id": 4321,"name": "UI/UX Designer"},"position": "UI/UX Designer"},
            {"id": 9012,"image": "https://i.pravatar.cc/100?7","name": "Nama Pegawai Tujuh","phone": "987-123-6540","division": {"id": 6543,"name": "Mobile Apps"},"position": "Junior Developer"},
            {"id": 3456,"image": "https://i.pravatar.cc/100?8","name": "Nama Pegawai Delapan","phone": "234-567-8901","division": {"id": 7890,"name": "QA"},"position": "QA Tester"},
            {"id": 7890,"image": "https://i.pravatar.cc/100?9","name": "Nama Pegawai Sembilan","phone": "876-543-2109","division": {"id": 1234,"name": "Full Stack"},"position": "Software Engineer"},
            {"id": 4567,"image": "https://i.pravatar.cc/100?10","name": "Nama Pegawai Sepuluh","phone": "567-890-1234","division": {"id": 5678,"name": "Backend"},"position": "Database Admin"},
            {"id": 9013,"image": "https://i.pravatar.cc/100?11","name": "Nama Pegawai Sebelas","phone": "678-901-2345","division": {"id": 9012,"name": "Frontend"},"position": "Frontend Engineer"},
            {"id": 2346,"image": "https://i.pravatar.cc/100?12","name": "Nama Pegawai Dua Belas","phone": "789-012-3456","division": {"id": 3456,"name": "UI/UX Designer"},"position": "Graphic Designer"},
            {"id": 7891,"image": "https://i.pravatar.cc/100?13","name": "Nama Pegawai Tiga Belas","phone": "901-234-5678","division": {"id": 6789,"name": "Mobile Apps"},"position": "Mobile Developer"},
            {"id": 1235,"image": "https://i.pravatar.cc/100?14","name": "Nama Pegawai Empat Belas","phone": "012-345-6789","division": {"id": 2345,"name": "QA"},"position": "QA Automation"},
            {"id": 5679,"image": "https://i.pravatar.cc/100?15","name": "Nama Pegawai Lima Belas","phone": "345-678-9012","division": {"id": 7891,"name": "Full Stack"},"position": "Web Developer"},
            {"id": 8766,"image": "https://i.pravatar.cc/100?16","name": "Nama Pegawai Enam Belas","phone": "567-901-2348","division": {"id": 1235,"name": "Backend"},"position": "System Admin"},
            {"id": 3422,"image": "https://i.pravatar.cc/100?17","name": "Nama Pegawai Tujuh Belas","phone": "987-654-3211","division": {"id": 9013,"name": "Frontend"},"position": "React Developer"},
            {"id": 6780,"image": "https://i.pravatar.cc/100?18","name": "Nama Pegawai Delapan Belas","phone": "123-789-4560","division": {"id": 4567,"name": "UI/UX Designer"},"position": "UX Researcher"},
            {"id": 9014,"image": "https://i.pravatar.cc/100?19","name": "Nama Pegawai Sembilan Belas","phone": "456-123-7890","division": {"id": 5679,"name": "Mobile Apps"},"position": "iOS Developer"},
            {"id": 1236,"image": "https://i.pravatar.cc/100?20","name": "Nama Pegawai Dua Puluh","phone": "789-456-1230","division": {"id": 8766,"name": "QA"},"position": "Manual Tester"},
            {"id": 4568,"image": "https://i.pravatar.cc/100?21","name": "Nama Pegawai Dua Puluh Satu","phone": "987-321-6540","division": {"id": 3422,"name": "Full Stack"},"position": "Backend Engineer"},
            {"id": 6790,"image": "https://i.pravatar.cc/100?22","name": "Nama Pegawai Dua Puluh Dua","phone": "321-987-6540","division": {"id": 6780,"name": "Backend"},"position": "Cloud Engineer"},
            {"id": 2347,"image": "https://i.pravatar.cc/100?23","name": "Nama Pegawai Dua Puluh Tiga","phone": "654-987-3210","division": {"id": 9014,"name": "Frontend"},"position": "Angular Developer"},
            {"id": 7892,"image": "https://i.pravatar.cc/100?24","name": "Nama Pegawai Dua Puluh Empat","phone": "876-432-1098","division": {"id": 1236,"name": "UI/UX Designer"},"position": "Interaction Designer"},
            {"id": 1237,"image": "https://i.pravatar.cc/100?25","name": "Nama Pegawai Dua Puluh Lima","phone": "109-876-5432","division": {"id": 4568,"name": "Mobile Apps"},"position": "Android Developer"},
            {"id": 4569,"image": "https://i.pravatar.cc/100?26","name": "Nama Pegawai Dua Puluh Enam","phone": "234-678-9010","division": {"id": 6790,"name": "QA"},"position": "Performance Tester"},
            {"id": 9015,"image": "https://i.pravatar.cc/100?27","name": "Nama Pegawai Dua Puluh Tujuh","phone": "567-890-1234","division": {"id": 2347,"name": "Full Stack"},"position": "DevOps Engineer"},
            {"id": 6791,"image": "https://i.pravatar.cc/100?28","name": "Nama Pegawai Dua Puluh Delapan","phone": "432-109-8765","division": {"id": 7892,"name": "Backend"},"position": "Data Engineer"},
            {"id": 3457,"image": "https://i.pravatar.cc/100?29","name": "Nama Pegawai Dua Puluh Sembilan","phone": "789-012-3456","division": {"id": 1237,"name": "Frontend"},"position": "Vue Developer"},
            {"id": 8767,"image": "https://i.pravatar.cc/100?30","name": "Nama Pegawai Tiga Puluh","phone": "901-234-5678","division": {"id": 4569,"name": "UI/UX Designer"},"position": "Product Designer"},
            {"id": 2348,"image": "https://i.pravatar.cc/100?31","name": "Nama Pegawai Tiga Puluh Satu","phone": "345-678-9012","division": {"id": 9015,"name": "Mobile Apps"},"position": "Flutter Developer"},
            {"id": 5680,"image": "https://i.pravatar.cc/100?32","name": "Nama Pegawai Tiga Puluh Dua","phone": "678-901-2345","division": {"id": 6791,"name": "QA"},"position": "Security Tester"},
            {"id": 9016,"image": "https://i.pravatar.cc/100?33","name": "Nama Pegawai Tiga Puluh Tiga","phone": "012-345-6789","division": {"id": 3457,"name": "Full Stack"},"position": "Full Stack Developer"}
        ]';
        $employees = json_decode($jsonData, true);

        foreach ($employees as $employeeData) {
            $division = Division::firstOrCreate(['name' => $employeeData['division']['name']]);

            Employee::create([
                'image' => $employeeData['image'],
                'name' => $employeeData['name'],
                'phone' => $employeeData['phone'],
                'division_id' => $division->id,
                'position' => $employeeData['position'],
            ]);
        }
    }
}