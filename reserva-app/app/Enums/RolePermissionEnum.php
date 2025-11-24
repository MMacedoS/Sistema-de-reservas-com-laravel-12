<?php

namespace App\Enums;

enum RolePermissionEnum: string
{
    case RECEPCIONISTA = 'recepcionista';
    case ADMIN = 'admin';
    case GERENTE = 'gerente';
    case GARCOM = 'garcom';

    public function label(): string
    {
        return match ($this) {
            self::RECEPCIONISTA => 'Recepcionista',
            self::ADMIN => 'Administrador',
            self::GERENTE => 'Gerente',
            self::GARCOM => 'Garcom',
        };
    }

    public function list(): array
    {
        return match ($this) {
            self::RECEPCIONISTA => [
                'create_reservation',
                'view_reservation',
                'update_reservation',
                'delete_reservation',
                'check_in_guest',
                'check_out_guest',
                'manage_room_assignments',
                'payments_processing',
                'customer_create',
                'customer_view',
                'customer_update',
                'customer_delete',
                'sale_services'
            ],
            self::ADMIN => [
                'create_user',
                'delete_user',
                'update_user',
                'view_user',
                'manage_roles',
                'view_reports',
                'create_reservation',
                'view_reservation',
                'update_reservation',
                'delete_reservation',
                'check_in_guest',
                'check_out_guest',
                'manage_room_assignments',
                'payments_processing',
                'customer_create',
                'customer_view',
                'customer_update',
                'customer_delete',
                'sale_services'
            ],
            self::GERENTE => [
                'create_user',
                'delete_user',
                'update_user',
                'view_user',
                'view_reports',
                'create_reservation',
                'view_reservation',
                'update_reservation',
                'delete_reservation',
                'check_in_guest',
                'check_out_guest',
                'manage_room_assignments',
                'payments_processing',
                'customer_create',
                'customer_view',
                'customer_update',
                'customer_delete',
                'sale_services'
            ],
            self::GARCOM => [
                'manage_orders',
                'view_menu',
                'process_payments',
                'table_management'
            ],
        };
    }
}
