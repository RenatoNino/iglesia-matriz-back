<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $date = Carbon::now();

        // Persons
        $admin_person_id = DB::table('person')->insertGetId([
            'document_type' => 'DNI',
            'document_number' => '12345678',
            'names' => 'Admin',
            'phone' => '123456789',
            'email' => 'admin@gmail.com',
            'created_at' => $date,
            'updated_at' => $date,
        ]);

        // Users
        $admin_user_id = DB::table('user')->insertGetId([
            'person_id' => $admin_person_id,
            'email' => 'admin@gmail.com',
            'password' => bcrypt('admin'),
            'created_at' => $date,
            'updated_at' => $date,
        ]);

        // Roles
        $role_id_admin = DB::table('role')->insertGetId([
            'name' => 'ADMINISTRADOR',
            'created_at' => $date,
            'updated_at' => $date,
        ]);

        // User Roles
        DB::table('role_user')->insert([
            'user_id' => $admin_user_id,
            'role_id' => $role_id_admin,
        ]);

        // Menus
        $menu_id_principal = DB::table('menu')->insertGetId([
            'name' => 'Principal',
            'created_at' => $date,
            'updated_at' => $date,
        ]);
        $menu_id_preferencias = DB::table('menu')->insertGetId([
            'name' => 'Preferencias',
            'created_at' => $date,
            'updated_at' => $date,
        ]);
        $menu_id_acceso_rapido = DB::table('menu')->insertGetId([
            'name' => 'Acceso Rápido',
            'created_at' => $date,
            'updated_at' => $date,
        ]);
        $menu_id_configuracion = DB::table('menu')->insertGetId([
            'name' => 'Configuración',
            'created_at' => $date,
            'updated_at' => $date,
        ]);

        // Menu Principal - Options
        $option_id_home = DB::table('option')->insertGetId([
            'menu_id' => $menu_id_principal,
            'name' => 'Inicio',
            'name_url' => 'Home',
            'created_at' => $date,
            'updated_at' => $date,
        ]);

        // Menu Preferencias - Options
        $option_id_settings = DB::table('option')->insertGetId([
            'menu_id' => $menu_id_preferencias,
            'name' => 'Ajustes',
            'name_url' => 'Settings',
            'created_at' => $date,
            'updated_at' => $date,
        ]);

        // Menu Acceso Rápido - Options
        $option_id_profile = DB::table('option')->insertGetId([
            'menu_id' => $menu_id_acceso_rapido,
            'name' => 'Mi Perfil',
            'name_url' => 'Profile',
            'created_at' => $date,
            'updated_at' => $date,
        ]);

        // Menu Configuración - Options
        $option_id_users = DB::table('option')->insertGetId([
            'menu_id' => $menu_id_configuracion,
            'name' => 'Usuarios',
            'name_url' => 'UsersList',
            'created_at' => $date,
            'updated_at' => $date,
        ]);
        $option_id_mass_types = DB::table('option')->insertGetId([
            'menu_id' => $menu_id_configuracion,
            'name' => 'Tipos de Misa',
            'name_url' => 'MassTypeList',
            'created_at' => $date,
            'updated_at' => $date,
        ]);

        // Role Options- Admin
        DB::table('role_option')->insert([
            'role_id' => $role_id_admin,
            'option_id' => $option_id_home,
        ]);
        DB::table('role_option')->insert([
            'role_id' => $role_id_admin,
            'option_id' => $option_id_settings,
        ]);
        DB::table('role_option')->insert([
            'role_id' => $role_id_admin,
            'option_id' => $option_id_profile,
        ]);
        DB::table('role_option')->insert([
            'role_id' => $role_id_admin,
            'option_id' => $option_id_users,
        ]);
        DB::table('role_option')->insert([
            'role_id' => $role_id_admin,
            'option_id' => $option_id_mass_types,
        ]);

        // System Configuration
        DB::table('system_configuration')->insert([
            'key' => 'application_name',
            'name' => 'Nombre de la institución',
            'type' => 'string',
            'value' => 'Instutución',
            'created_at' => $date,
            'updated_at' => $date,
        ]);
        DB::table('system_configuration')->insert([
            'key' => 'logo',
            'name' => 'Logo',
            'type' => 'string',
            'value' => null,
            'created_at' => $date,
            'updated_at' => $date,
        ]);
        DB::table('system_configuration')->insert([
            'key' => 'favicon',
            'name' => 'Favicon',
            'type' => 'string',
            'value' => null,
            'created_at' => $date,
            'updated_at' => $date,
        ]);
        DB::table('system_configuration')->insert([
            'key' => 'banner',
            'name' => 'Banner',
            'type' => 'string',
            'value' => null,
            'created_at' => $date,
            'updated_at' => $date,
        ]);
        DB::table('system_configuration')->insert([
            'key' => 'primary_color',
            'name' => 'Color Primario',
            'type' => 'string',
            'value' => '#7367F0',
            'created_at' => $date,
            'updated_at' => $date,
        ]);

        // Mass Types
        DB::table('mass_type')->insert([
            'name' => 'Misa de difuntos',
            'slug' => 'misa-difuntos',
            'created_at' => $date,
            'updated_at' => $date,
        ]);
        DB::table('mass_type')->insert([
            'name' => 'Misa de acción de gracias',
            'slug' => 'misa-accion-gracias',
            'created_at' => $date,
            'updated_at' => $date,
        ]);
        DB::table('mass_type')->insert([
            'name' => 'Misa de gloria',
            'slug' => 'misa-gloria',
            'created_at' => $date,
            'updated_at' => $date,
        ]);
        DB::table('mass_type')->insert([
            'name' => 'Misa de salud',
            'slug' => 'misa-salud',
            'created_at' => $date,
            'updated_at' => $date,
        ]);
    }
}
