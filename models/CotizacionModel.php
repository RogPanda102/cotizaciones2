<?php

class CotizacionModel
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAll()
    {
        $sql = "
            SELECT
                cotizaciones.*,

                empresas.nombre AS empresa_nombre,
                dependencias.nombre_oficial AS dependencia_nombre,
                departamentos.nombre_departamento AS departamento_nombre,
                analistas.nombre AS analista_nombre

            FROM cotizaciones

            LEFT JOIN empresas
                ON empresas.id = cotizaciones.empresa_id

            LEFT JOIN dependencias
                ON dependencias.id = cotizaciones.dependencia_id

            LEFT JOIN departamentos
                ON departamentos.id = cotizaciones.departamento_id

            LEFT JOIN analistas
                ON analistas.id = cotizaciones.analista_id

            ORDER BY cotizaciones.id DESC
        ";

        $stmt = $this->pdo->query($sql);

        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function getById($id)
    {
        $sql = "
            SELECT
                cotizaciones.*,

                empresas.nombre AS empresa_nombre,
                dependencias.nombre_oficial AS dependencia_nombre,
                departamentos.nombre_departamento AS departamento_nombre,
                analistas.nombre AS analista_nombre

            FROM cotizaciones

            LEFT JOIN empresas
                ON empresas.id = cotizaciones.empresa_id

            LEFT JOIN dependencias
                ON dependencias.id = cotizaciones.dependencia_id

            LEFT JOIN departamentos
                ON departamentos.id = cotizaciones.departamento_id

            LEFT JOIN analistas
                ON analistas.id = cotizaciones.analista_id

            WHERE cotizaciones.id = :id
            LIMIT 1
        ";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            ':id' => $id
        ]);

        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function getFormData()
    {
        return [

            'empresas' => $this->pdo
                ->query("SELECT * FROM empresas ORDER BY nombre")
                ->fetchAll(PDO::FETCH_OBJ),

            'dependencias' => $this->pdo
                ->query("SELECT * FROM dependencias ORDER BY nombre_oficial")
                ->fetchAll(PDO::FETCH_OBJ),

            'departamentos' => $this->pdo
                ->query("SELECT * FROM departamentos ORDER BY nombre_departamento")
                ->fetchAll(PDO::FETCH_OBJ),

            'analistas' => $this->pdo
                ->query("SELECT * FROM analistas ORDER BY nombre")
                ->fetchAll(PDO::FETCH_OBJ)

        ];
    }

    public function update($id, array $data)
    {
        $sql = "
            UPDATE cotizaciones
            SET
                empresa_id = :empresa_id,
                tipo_cotizacion = :tipo_cotizacion,
                estado = :estado,
                numero_cotizacion = :numero_cotizacion,
                folio_externo = :folio_externo,
                dependencia_id = :dependencia_id,
                departamento_id = :departamento_id,
                analista_id = :analista_id,
                fecha_envio = :fecha_envio,
                fecha_recepcion = :fecha_recepcion,
                horario_de_entrega = :horario_de_entrega,
                lugar_de_entrega = :lugar_de_entrega,
                monto_total = :monto_total,
                dias_credito = :dias_credito
            WHERE id = :id
        ";

        $stmt = $this->pdo->prepare($sql);

        $data['id'] = $id;

        return $stmt->execute($data);
    }

    public function create(array $data)
    {
        $sql = "
            INSERT INTO cotizaciones
            (
                empresa_id,
                tipo_cotizacion,
                estado,
                numero_cotizacion,
                folio_externo,
                dependencia_id,
                departamento_id,
                analista_id,
                fecha_envio,
                fecha_recepcion,
                garantia,
                monto_total,
                horario_de_entrega,
                lugar_de_entrega,
                dias_credito,
                tipo_dias
            )
            VALUES
            (
                :empresa_id,
                :tipo_cotizacion,
                :estado,
                :numero_cotizacion,
                :folio_externo,
                :dependencia_id,
                :departamento_id,
                :analista_id,
                :fecha_envio,
                :fecha_recepcion,
                :garantia,
                :monto_total,
                :horario_de_entrega,
                :lugar_de_entrega,
                :dias_credito,
                :tipo_dias
            )
        ";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            ':empresa_id' => $data['empresa_id'],
            ':tipo_cotizacion' => $data['tipo_cotizacion'],
            ':estado' => $data['estado'],
            ':numero_cotizacion' => $data['numero_cotizacion'],
            ':folio_externo' => $data['folio_externo'],
            ':dependencia_id' => $data['dependencia_id'],
            ':departamento_id' => $data['departamento_id'],
            ':analista_id' => $data['analista_id'],
            ':fecha_envio' => $data['fecha_envio'],
            ':fecha_recepcion' => $data['fecha_recepcion'],
            ':garantia' => $data['garantia'],
            ':monto_total' => $data['monto_total'],
            ':horario_de_entrega' => $data['horario_de_entrega'],
            ':lugar_de_entrega' => $data['lugar_de_entrega'],
            ':dias_credito' => $data['dias_credito'],
            ':tipo_dias' => $data['tipo_dias']
        ]);
    }

        public function tienePedidos($id)
    {
        $sql = "
            SELECT COUNT(*)
            FROM pedidos
            WHERE cotizacion_id = ?
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);

        return $stmt->fetchColumn() > 0;
    }

    public function delete($id)
    {
        $sql = "
            DELETE FROM cotizaciones
            WHERE id = ?
        ";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([$id]);
    }

}