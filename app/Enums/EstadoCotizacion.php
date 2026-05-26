<?php
namespace App\Enums;

enum EstadoCotizacion: string
{
    case ENVIADO = 'enviado';
    case RESPALDO  = 'respaldo';
    case NO_COTIZA     = 'no_cotiza';

    public function label(): string
    {
        return match($this) {
            self::ENVIADO => 'Enviado',
            self::RESPALDO  => 'Respaldo',
            self::NO_COTIZA     => 'No cotizada',
        };
    }
    

    public function color(): string
    {
        return match($this) {
            self::ENVIADO => 'primary',
            self::RESPALDO => 'warning',
            self::NO_COTIZA => 'dark',
        };
    }
}