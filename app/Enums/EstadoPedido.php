<?php
namespace App\Enums;

enum EstadoPedido: string
{
    case EN_PROCESO = 'en_proceso';
    case FACTURADO  = 'facturado';
    case ENTREGADO  = 'entregado';
    case PAGADO     = 'pagado';
    

    public function label(): string
    {
        return match($this) {
            self::EN_PROCESO => 'En proceso',
            self::FACTURADO  => 'Facturado',
            self::ENTREGADO  => 'Entregado',
            self::PAGADO     => 'Pagado',
            
        };
    }
    public function siguientesEstados(): array
    {
        return match($this) {
            self::EN_PROCESO => [self::ENTREGADO],
            self::ENTREGADO  => [self::FACTURADO],
            self::FACTURADO  => [self::PAGADO],
            self::PAGADO     => [],
        };
    }
    public function puedeCambiarA(self $nuevoEstado): bool
    {
        return in_array($nuevoEstado, $this->siguientesEstados(), true);
    }
    public function badge(): string
    {
        return match($this) {
            self::EN_PROCESO => 'secondary',
            self::FACTURADO => 'primary',
            self::ENTREGADO => 'warning',
            self::PAGADO => 'success',
        };
    }
    public function esFinal(): bool
    {
        return $this === self::PAGADO;
    }
    public function noEsFinal(): bool
    {
        return !$this->esFinal();
    }
    public function requiereFechaFacturacion(): bool
    {
        return $this === self::FACTURADO;
    }
    public function bloqueaCompras(): bool
    {
        return in_array($this, [
            self::FACTURADO,
            self::ENTREGADO,
            self::PAGADO
        ]);
    }
}